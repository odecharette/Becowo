<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Entity\PaiementTransaction;

class PaiementController extends Controller
{

  public function callBankAction(Request $request)
  {
     $paiementInfos = $this->container->getParameter('creditAgricole');
     $currentUser = $this->getUser();
     $userEmail = $currentUser->getEmail();
     $priceToPay = $request->get('priceToPay');
     $bookingRef = $request->get('bookingRef');


    /************************************/
    //On doit ici calculer l'empreinte du message pour assurer la sécurité du paiement

    // On récupère la date au format ISO-8601
    $dateISO = date("c"); 
    // On crée la chaîne à hacher sans URLencodage
    $msg = "PBX_SITE=" . $paiementInfos['PBX_SITE'] . 
    "&PBX_RANG=" . $paiementInfos['PBX_RANG'] . 
    "&PBX_IDENTIFIANT=" . $paiementInfos['PBX_IDENTIFIANT'] . 
    "&PBX_TOTAL=" . $priceToPay .
    "&PBX_DEVISE=" . $paiementInfos['PBX_DEVISE'] . 
    "&PBX_CMD=" . $bookingRef . 
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

    return $this->render('Paiement/payer.html.twig', array('paiementInfos' =>$paiementInfos, 'priceToPay' => $priceToPay, 'bookingRef' => $bookingRef, 'userEmail' => $userEmail, 'dateISO' => $dateISO, 'hmacCalculated' => $hmacCalculated));
  }

  public function effectueAction(Request $request)
  {
    $error_code = $request->get('Erreur'); 
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
    $error_code = $request->get('Erreur'); 
    if($error_code != "00000")
    {
      // La transaction a générée une erreur
      $errorService = $this->get('app.error');
      $error = $errorService->getErrorByCode($error_code);
      $error_msg = $error[0]['sentence'];
    }
    return $this->render('Paiement/annule.html.twig');
  }

  public function refuseAction(Request $request)
  {
    $error_code = $request->get('Erreur'); 
    if($error_code != "00000")
    {
      // La transaction a générée une erreur
      $errorService = $this->get('app.error');
      $error = $errorService->getErrorByCode($error_code);
      $error_msg = $error[0]['sentence'];
    }
    return $this->render('Paiement/refuse.html.twig');
  }


  public function ipnAction(Request $request)
  {
    /* Lors de l’appel de cette URL, un script présent sur le serveur Marchand à l’emplacement spécifié par l’URL, va s’exécuter. Il n’y a pas de contrainte sur le langage de ce script (ASP, PHP, PERL, …). La seule limitation est que ce script ne doit pas faire de redirection et doit générer une page HTML vide. */


    // pour tester (changer de ref de booking à chaque fois) : URL : http://localhost/Becowo/web/app_dev.php/ws/paiement/ipn?ref=582ed7f9441a9&call_number=71256&authorization_number=30258&total=2000&abonnement=354341&erreur=00000&sign=

    dump($request);
    $booking_ref = $request->get('ref');
    $call_number = $request->get('call_number');  //Numéro d’appel  
    $authorization_number = $request->get('authorization_number'); // numéro d’Autorisation (numéro remis par le centre d’autorisation) 
    $total = $request->get('total'); // Montant de la transaction 
    $abonnement = $request->get('abonnement'); // numéro d’abonnement (numéro remis par la plateforme)
    $error_code = $request->get('erreur'); 
    $signature = $request->get('sign'); // Signature sur les variables de l’URL. Format : url-encodé 
    $uri = $_SERVER['REQUEST_URI'];
    $paramList = explode('?', $uri);

    $WsService = $this->get('app.workspace');
    $booking = $WsService->getBookingByRef($booking_ref);

    $errorService = $this->get('app.error');
    $error = $errorService->getErrorByCode($error_code);

    // Vérifier l'IP qui appel cette URL pouor assurer que ca provient bien de la banque
    $clientIP = $request->getClientIp();
    $CreditAgricoleIP = ['195.101.99.76', '194.2.122.158', '194.2.122.190', '195.25.7.166', '195.25.67.22'];
    $trusted_IP = in_array($clientIP, $CreditAgricoleIP);

    // Vérifier la signature
    // Lecture de la clé publique depuis le certificat
  //  $pubkeyid = openssl_pkey_get_public($this->get('kernel')->getRootDir(). '/../web/KeyCreditAgricole/pubkey.pem');
    $fp = fopen($this->get('kernel')->getRootDir(). '/../web/KeyCreditAgricole/pubkey.pem', "r");
    $pubkeyid = fread($fp, 8192);
    fclose($fp);
    /***************************************************************/
    $data = $paramList[1]; 
    $trusted_Signature = openssl_verify($data, $signature, $pubkeyid);

    $em = $this->getDoctrine()->getManager();


    // On vérifie si la transaction est valide
    // * $error_code = "00000"
    // * $authorization_number = "XXXXXX" si test sinon != null (param non envoyé si transaction refusée)
    // * $trusted_IP = true
    // * $trusted_Signature = true

    // ************* if désactivé juste pour tester l'envoi de l'email
//   if($error_code = "00000" && $authorization_number != null && $trusted_IP && $trusted_Signature)

    if(true)
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
        ->setTo('odecharette@gmail.com') // TO DO récup email du manager
        ->setBody(
            $this->renderView(
                'CommonViews/Mail/New-dme-resa.html.twig',
                array(
                    'user' => $this->getUser()->getFirstname() . ' ' . $this->getUser()->getName(),
                    'booking' => $booking
                )
            )
        );

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

 


    



    return $this->render('Paiement/ipn.html.twig');
  }
}
