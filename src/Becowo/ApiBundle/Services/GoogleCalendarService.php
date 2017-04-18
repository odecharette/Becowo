<?php

namespace Becowo\ApiBundle\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;

class GoogleCalendarService
{
    private $googleCalendarAPI = null;

    public function __construct($googleCalendarAPI)
    {
        $this->googleCalendarAPI = $googleCalendarAPI;
    }

    public function createJWT()
    {
        // 1. Création d'un JWT valable 1 heure : 
        // https://developers.google.com/identity/protocols/OAuth2ServiceAccount#creatingjwt
        // solution sans bundle
        
        $jwtHeader = $this->base64url_encode(json_encode(array(
            "alg" => "RS256",
            "typ" => "JWT"
        )));
        
        $now = time();
        // "iss" vient du fichier généré par google lors de la création d'un compte de service dans la console google : https://console.developers.google.com/apis/credentials?project=protean-keyword-132623
        $jwtClaim = $this->base64url_encode(json_encode(array(
            "iss" => $this->googleCalendarAPI['serviceAccountEmail'], //"becowo@protean-keyword-132623.iam.gserviceaccount.com",
            "scope" => "https://www.googleapis.com/auth/calendar",
            "aud" => "https://www.googleapis.com/oauth2/v4/token",
            "exp" => $now + 3600,
            "iat" => $now
        )));
        
        // L'énorme clé vient du fichier généré par google lors de la création d'un compte de service dans la console google : https://console.developers.google.com/apis/credentials?project=protean-keyword-132623
        openssl_sign(
            $jwtHeader.".".$jwtClaim,
            $jwtSig,
            $this->googleCalendarAPI['serviceAccountKey'],
            "sha256WithRSAEncryption"
        );
        $jwtSign = $this->base64url_encode($jwtSig);

        //{Base64url encoded JSON header}.{Base64url encoded JSON claim set}.{Base64url encoded signature}
        return $jwtHeader.".".$jwtClaim.".".$jwtSign;
    }

    // TO DO : check if JWT is still valide. If not, create a new one

    public function createAccessToken($jwt)
    {
        // 2. On POST le $JWT crée en étape 1 pour obtenir un token d'accès à l'API de google (valable 1 heure)

        $url = "https://www.googleapis.com/oauth2/v4/token";

        $response = \Httpful\Request::post($url)
            ->body('grant_type=urn%3Aietf%3Aparams%3Aoauth%3Agrant-type%3Ajwt-bearer&assertion=' . $jwt)
            ->addHeaders(array(
                'Content-Type' => 'application/x-www-form-urlencoded',
            ))
            ->send();

        return $response->body->access_token;

    }  

    public function getGoogleCalendarEvents($userCalendarID, $access_token)
    {
        // 3. On accède au calendar via l'API

        // IMPORTANT ; pour accéder à un calendrier user, il doit être partagé avec l'email becowo@protean-keyword-132623.iam.gserviceaccount.com
        // cet email correspond au compte de service crée dans la console google de becowo@gmail.com
        $url = "https://www.googleapis.com/calendar/v3/calendars/" . $userCalendarID . "/events";

        $response = \Httpful\Request::get($url)
            ->addHeader('Authorization', 'Bearer ' . $access_token)
            ->send();

        return $response->body->items;
    } 

    public function base64url_encode($data) 
    { 
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');  
    }

}
