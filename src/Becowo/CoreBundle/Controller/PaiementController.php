<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PaiementController extends Controller
{

  public function callBankAction(Request $request)
  {
     $paiementService = $this->get('app.paiement');
     $paiementInfos = $paiementService->getPaiementInfos();
     $currentUser = $this->getUser();
     $userEmail = $currentUser->getEmail();
     $montant = $request->get('montant');
     $numCmd = "1" ; // TO DO


    /************************************/
    //On doit ici calculer l'empreinte du message pour assurer la sécurité du paiement

    // On récupère la date au format ISO-8601
    $dateISO = date("c"); 
    // On crée la chaîne à hacher sans URLencodage
    $msg = "PBX_SITE=" . $paiementInfos[0]['p_pbxSite'] . 
    "&PBX_RANG=" . $paiementInfos[0]['p_pbxRang'] . 
    "&PBX_IDENTIFIANT=" . $paiementInfos[0]['p_pbxIdentifiant'] . 
    "&PBX_TOTAL=" . $montant .
    "&PBX_DEVISE=" . $paiementInfos[0]['p_pbxDevise'] . 
    "&PBX_CMD=" . $numCmd . 
    "&PBX_PORTEUR=" . $userEmail . 
    "&PBX_RETOUR=" . $paiementInfos[0]['p_pbxRetour'] . 
    "&PBX_HASH=" . $paiementInfos[0]['p_pbxHash'] .
    "&PBX_TIME=".$dateISO; 


    // On récupère la clé secrète HMAC (stockée dans une base de données cryptée) et que l’on renseigne dans la variable 
    $keyTest = $paiementInfos[0]['p_pbxHmac'];
    // Si la clé est en ASCII, On la transforme en binaire
    $binKey = pack("H*", $keyTest);  
    // On calcule l’empreinte (à renseigner dans le paramètre PBX_HMAC) grâce à la fonction hash_hmac et la clé binaire
    // On envoie via la variable PBX_HASH l'algorithme de hachage qui a été utilisé (SHA512 dans ce cas).
    // Pour afficher la liste des algorithmes disponibles sur votre environnement, décommentez la ligne suivante
    //print_r(hash_algos());  #} 

    $hmacCalculated = strtoupper(hash_hmac($paiementInfos[0]['p_pbxHash'], $msg, $binKey)); 
    // La chaîne sera envoyée en majuscules, d'où l'utilisation de strtoupper()

    return $this->render('Paiement/payer.html.twig', array('paiementInfos' =>$paiementInfos, 'montant' => $montant, 'numCmd' => $numCmd, 'userEmail' => $userEmail, 'dateISO' => $dateISO, 'hmacCalculated' => $hmacCalculated));
  }
}
