<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
    "&PBX_TIME=".$dateISO; 


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
}
