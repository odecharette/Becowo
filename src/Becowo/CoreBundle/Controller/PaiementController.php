<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Entity\PaiementTransaction;

class PaiementController extends Controller
{

  public function callBankAction(Request $request)
  {
    if($request->isMethod('GET'))
    {

    $paiementInfos = $this->container->getParameter('creditAgricole');
    $currentUser = $this->getUser();
    $userEmail = $currentUser->getEmail();

    $session = $request->getSession();
    $booking = $session->get('booking');
    $WsService = $this->get('app.workspace');
    $WsHasOffice = $WsService->getWsHasOfficeById($booking->getWorkspaceHasOffice());
    $ws = $WsHasOffice->getWorkspace();

    /************************************/
    //On doit ici calculer l'empreinte du message pour assurer la sécurité du paiement

    // On récupère la date au format ISO-8601
    $dateISO = date("c"); 
    // On crée la chaîne à hacher sans URLencodage
    $msg = "PBX_SITE=" . $paiementInfos['PBX_SITE'] . 
    "&PBX_RANG=" . $paiementInfos['PBX_RANG'] . 
    "&PBX_IDENTIFIANT=" . $paiementInfos['PBX_IDENTIFIANT'] . 
    "&PBX_TOTAL=" . $booking->getPriceInclTax() * 100 . // on doit envoyer le prix à payer en cts à la banque
    "&PBX_DEVISE=" . $paiementInfos['PBX_DEVISE'] . 
    "&PBX_CMD=" . $booking->getBookingRef() . 
    "&PBX_PORTEUR=" . $userEmail . 
    "&PBX_RETOUR=" . $paiementInfos['PBX_RETOUR'] . 
    "&PBX_HASH=" . $paiementInfos['PBX_HASH'] .
    "&PBX_TIME=".$dateISO .
    "&PBX_EFFECTUE=".$paiementInfos['PBX_EFFECTUE'] .
    "&PBX_REFUSE=".$paiementInfos['PBX_REFUSE'] .
    "&PBX_ANNULE=".$paiementInfos['PBX_ANNULE'] .
    "&PBX_REPONDRE_A=".$paiementInfos['PBX_REPONDRE_A']; 


    // On récupère la clé secrète HMAC (stockée dans une base de données cryptée) et que l’on renseigne dans la variable 
    $keyTest = $paiementInfos['PBX_HMAC'];
    // Si la clé est en ASCII, On la transforme en binaire
    $binKey = pack("H*", $keyTest);  
    // On calcule l’empreinte (à renseigner dans le paramètre PBX_HMAC) grâce à la fonction hash_hmac et la clé binaire
    // On envoie via la variable PBX_HASH l'algorithme de hachage qui a été utilisé (SHA512 dans ce cas).
    // Pour afficher la liste des algorithmes disponibles sur votre environnement, décommentez la ligne suivante
    //print_r(hash_algos());  #} 

    $hmacCalculated = strtoupper(hash_hmac($paiementInfos['PBX_HASH'], $msg, $binKey)); 
    // La chaîne sera envoyée en majuscules, d'où l'utilisation de strtoupper()

    return $this->render('Paiement/payer.html.twig', array('creditAgricole' =>$paiementInfos, 'booking' => $booking, 'userEmail' => $userEmail, 'dateISO' => $dateISO, 'hmacCalculated' => $hmacCalculated, 'ws' => $ws));

    }
  }

  public function effectueAction(Request $request)
  {
    $error_code = $request->get('erreur'); 
    $error_msg = "";
    if($error_code != "00000")
    {
      // La transaction a générée une erreur
      $errorService = $this->get('app.error');
      $error = $errorService->getErrorByCode($error_code);
      $error_msg = $error[0]['sentence'];
    }

    return $this->render('Paiement/effectue.html.twig', array('error_msg' => $error_msg));
  }

  public function annuleAction(Request $request)
  {
    $error_code = $request->get('erreur'); 
    // La transaction a générée une erreur
    $errorService = $this->get('app.error');
    if($error_code != null)
    {     
      $error = $errorService->getErrorByCode($error_code);
      $error_msg = $error->getSentence();
    }
    else{
      $error_msg = "";
    }
    return $this->render('Paiement/annule.html.twig', array('error_msg' => $error_msg));
  }

  public function refuseAction(Request $request)
  {
    $error_code = $request->get('erreur'); 
    // La transaction a générée une erreur
    $errorService = $this->get('app.error');
    $error = $errorService->getErrorByCode($error_code);
    $error_msg = $error->getSentence();
    return $this->render('Paiement/refuse.html.twig', array('error_msg' => $error_msg));
  }


  public function ipnAction(Request $request)
  {
    /* Cette action est appelée par le Crédit Agricole pour faire un retour sur le paiement */
    /* Cette action doit renvoyer une page HTML vide */

    // pour tester (supprimer la transaction en BDD) : URL : http://localhost/Becowo/web/app_dev.php/ws/paiement/ipn?Montant=1000&Ref=5832be24b67bb&call_number=71256&authorization_number=30258&erreur=00000

    // Récupération des paramètres envoyés par le CréditAgricole (liste configurable dans le fichier de config) 
    $total = $request->get('Montant'); // Montant de la transaction 
    $booking_ref = $request->get('Ref'); // Référence de la réservation
    $call_number = $request->get('call_number');  //Numéro d’appel  
    $authorization_number = $request->get('authorization_number'); // numéro d’Autorisation (numéro remis par le centre d’autorisation)
    $error_code = $request->get('erreur'); // Code retour de la transation (voir table ErrorCodes)
    $signature = $request->get('sign'); // Signature sur les variables de l’URL. Format : url-encodé 

    // Construction de l'objet Booking correspondant à la transaction
    $WsService = $this->get('app.workspace');
    $booking = $WsService->getBookingByRef($booking_ref);

    //Récupération de l'email du manager de l'espace réservé
    // Multi email accepté si plusieurs teamMembers
    // Si aucun teammeber => envoi email à olivia.decharette@becowo.com
    // Si env != Prod => envoi email à olivia.decharette@becowo.com
    $objectBookingComplet = $WsService->getWsByBooking($booking);
    $ws = $objectBookingComplet->getWorkspaceHasOffice()->getWorkspace();
    $wsHasTeamMembers = $WsService->getWsHasTeamMemberForEmailBookingByWorkspace($ws);

    $emailManager = [];
    $i = 0;
    if($wsHasTeamMembers == null or $this->container->get( 'kernel' )->getEnvironment() != 'prod')
    {
      $emailManager[0] = 'olivia.decharette@becowo.com';
    }else{
      foreach ($wsHasTeamMembers as $wsHasTeamMember ) {
        $emailManager[$i] = $wsHasTeamMember->getTeamMember()->getEmail();
        $i ++;
      }
    }
   
    // Construction de l'objet Error correspond au code retour de la transaction
    $errorService = $this->get('app.error');
    $error = $errorService->getErrorByCode($error_code);

    // Vérifier l'IP qui appel cette URL pour assurer que ca provient bien de la banque
    $clientIP = $request->getClientIp();
    $CreditAgricoleIP = ['195.101.99.76', '194.2.122.158', '194.2.122.190', '195.25.7.166', '195.25.67.22'];
    $trusted_IP = in_array($clientIP, $CreditAgricoleIP);

    // Vérifier la signature de l'URL pour assurer que ca provient bien de la banque
    // Récupération de l'URL reçue pour récup la liste des paramètres
    $uri = $_SERVER['REQUEST_URI'];
    $paramList = explode('?', $uri);
    $data = $paramList[1]; 
    // Lecture de la clé publique depuis le certificat
      //  $pubkeyid = openssl_pkey_get_public($this->get('kernel')->getRootDir(). '/../web/KeyCreditAgricole/pubkey.pem');
    $fp = fopen($this->get('kernel')->getRootDir(). '/../web/KeyCreditAgricole/pubkey.pem', "r");
    $pubkeyid = fread($fp, 8192);
    fclose($fp);
    /***************************************************************/
    $trusted_Signature = openssl_verify($data, $signature, $pubkeyid);


    $em = $this->getDoctrine()->getManager();


    // On vérifie si la transaction est valide
    // * $error_code = "00000"
    // * $authorization_number = "XXXXXX" si test sinon != null (param non envoyé si transaction refusée)
    // * $trusted_IP = true
    // * $trusted_Signature = true

    // ************* if désactivé juste pour tester l'envoi de l'email
   if($error_code = "00000" && $authorization_number != null && $trusted_IP && $trusted_Signature)
    // if(true)
    {
      $transaction_valide = true;

      // La transaction est valide, donc on update le statut de la réservation
      $status = $WsService->getStatusById(2); // "Id 2 : Paiement validé"
      $booking->setStatus($status);
      $em->persist($booking);

      //Puis on envoi un mail au manager pour valider la résa
      $message = \Swift_Message::newInstance()
        ->setSubject("Nouvelle demande de réservation - " . $booking_ref)
        ->setFrom($this->getUser()->getEmail())
        ->setTo($emailManager) 
        ->setBody(
            $this->renderView(
                'CommonViews/Mail/New-dme-resa.html.twig',
                array('user' => $this->getUser()->getFirstname() . ' ' . $this->getUser()->getName(),
                    'booking' => $booking)
            ));

      $this->get('mailer')->send($message);

      //Puis on envoi un mail au coworker pour l'informer que le paiement est valide
      $message = \Swift_Message::newInstance()
        ->setSubject("Becowo - Paiement en ligne confirmé - Réservation N°" . $booking_ref)
        ->setFrom('contact@becowo.com')
        ->setTo($this->getUser()->getEmail())
        ->setBody(
            $this->renderView(
                'CommonViews/Mail/Coworker-ResaPayee.html.twig',
                array('booking' => $booking)
            ));

      $this->get('mailer')->send($message);
    }
    else
    {
      $transaction_valide = false;

      // La transaction est refusé, donc on update le statut de la réservation
      $status = $WsService->getStatusById(3); // "Id 3 : Paiement refusé"
      $booking->setStatus($status);
      $em->persist($booking);
    }
    

    // Sauvegarde de la transaction en BDD
    $transaction = New PaiementTransaction();
    $transaction->setReturnCode($error);
    $transaction->setBooking($booking);
    $transaction->setAuthorizationNumber($authorization_number);
    $transaction->setTrustedIP($trusted_IP);
    $transaction->setTrustedSignature($trusted_Signature);
    $transaction->setTransactionIsValid($transaction_valide);
    $em->persist($transaction);

    $em->flush();

    // On renvoi une page HTML vide
    return $this->render('Paiement/ipn.html.twig');
  }
}
