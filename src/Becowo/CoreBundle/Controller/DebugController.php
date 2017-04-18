<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Httpful\Mime;

class DebugController extends Controller
{

  public function viewAction()
  {
    $contentToDump = "";
    $content = "";

    // Permet de tester l'envoi d'un email avec mailgun : 
  	// $emailService = $this->get('app.email');
  	// $emailTemplate = "Footer-contact";
  	// $emailParams = array('name' => 'prenom',
   //                'email' => 'prenom@test.com',
   //                'subject' => 'test debug',
   //                'message' => 'message');
  	// $emailTag = "test debug 2";
  	// $to = "odecharette@gmail.com";
  	// $subject = "test app.email";

  	// $content = $emailService->sendEmail($emailTemplate, $emailParams, $emailTag, $to, $subject);


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
        "iss" => "becowo@protean-keyword-132623.iam.gserviceaccount.com",
        "scope" => "https://www.googleapis.com/auth/calendar",
        "aud" => "https://www.googleapis.com/oauth2/v4/token",
        "exp" => $now + 3600,
        "iat" => $now
    )));
    
    // L'énorme clé vient du fichier généré par google lors de la création d'un compte de service dans la console google : https://console.developers.google.com/apis/credentials?project=protean-keyword-132623
    openssl_sign(
        $jwtHeader.".".$jwtClaim,
        $jwtSig,
        "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQC27o8kvqGyMzZg\ndEOqkU4i1ALUeoBNehf2srj+hLSEPT4VtoajeI3i5E0IBYLTDTCMjrVGzgbONlDx\ngTHMd9KYyzyxRKe2yWBNrhpSPKtFVdhSqvu8cYtlsIet11bFCuFDSnMTwDDa/Spm\n1MQoPDEBQL+RYvCPtzmYBoZ5G2+9DFMT/RuYsfWLqKAuIyuX664Bdpwn2WivSKY3\nThE4IPw4r9rF6ku1tq4IjyxJ+M1EQ+FoSXnXxmL7lvE7rBuYi4Jy/Pd0cH/titUk\n8u8kDKkCgas67QYc5KXfiSR+Oth6OgRPkQjprjNuB2zJgt4t0+PghVp4RoULEiM+\nRxjj+5Y9AgMBAAECggEAV3nOc4jBM8CvkQIn1Wm0jo0JaWfG8MWgrfSa6AK3e8D5\nblKhIYyldMktWNehzqCxBZW8c8ZTlMp+fG4GTTtDNpOBS1eER7EWXy8RISAn2nkJ\nf8aJqHw3Z4I571RZBtKEE7SHQPuXoTCM1S2LO55E5M98i95fIKpCXUNJjKIlFaX9\n4pdyTht7L/YDA2c9EO4/vaB4HdRIv92uq96J3poi1wRp04DNNV5AzhMtuomjIbDP\ndJSKMEnQUzEd8nLA7YN/XU59Ua9axww2Er+bEDhGGAQNJ9iEXa0gMsTJFdnHexq3\nLoJx/r2nQwx7UKt8SCqvikmeFEyLrdENLVLkHYZwoQKBgQDxdWi4ickzFSAY6voX\nhtDQEVkA0FsbNL8MV06eHwvLkjOeD6c9O1uRrf0NxeZ9ydl4ESv8ojbJ9nRSFLIE\nid8fLrQsQNGfIS+0ZCTvEu0sI3GDEsXyVpyP2GkadVu19axtQeq0hZSYivXb1XbO\nOCDRAxv6NrQUeJL7zR4MWWQ1uQKBgQDB8tZiDIirGuDjyUXP6eaOmq1YkW5R43g0\nmDFlN9ifmMrczbN6H8kNZv7c7nMxwfU60wba/NqCGToKUko9Frlq+siD1pCnDvB+\nBisE6ZE12ZjXyRZrYfUTjbafc7QVOFQ6Ey7Zf8EKIZo1uUAMbwet/2A9iBI/eaZM\nd8SvL4empQKBgHgDQV+nrIdlUqTP9ipHafZhCPnslbv6BZNeucbB65ztOBax9Q/s\nNuE7t3FnEd8nup2A+3oALndHth0uCCVVWb8n+YmdVhNf7VQeCnWB1LyBiWP6qsR+\n5CZjDCqIdmMEjwVnI/9B/c+sEfOIMBrjrvv0La26Dtu16miZVPwSWkqRAoGAQEue\nonaBQCfy8dChoiFqW1APs1LS/bao/NaPWXzABXiDl9thalTrM9Q3HUq3SYGBKHUY\nyrQURBjU0uMg1UuZQEvO+VXCMn+TXlPxIvnDN9ThBHgXRJX+xvKt3gJfasF3uqDt\nYREnD5LAKps1DmooY5hLcVqQohZT+PmjbGgXUjkCgYAXdzde9TP8GsxzaGUiENAF\n/qVJwcstlxba9UJ3d1KcSjDQoLyxFzkT+xudXGz1Uf2dtt2Z5Trgo5olqCv2Z4G8\nOWn3Gw5sCxj8gs/zdcIfxI9KiTQ1wSzglNweaPoeefQ2EYMhI2a6nLTui7lq4hR2\nV1m/E+psJMTepZ9HlaG0Ug==\n-----END PRIVATE KEY-----\n",
        "sha256WithRSAEncryption"
    );
    $jwtSign = $this->base64url_encode($jwtSig);

    //{Base64url encoded JSON header}.{Base64url encoded JSON claim set}.{Base64url encoded signature}
    $jwtAssertion = $jwtHeader.".".$jwtClaim.".".$jwtSign;


    // 2. On POST le $JWT crée en étape 1 pour obtenir un token d'accès à l'API de google (valable 1 heure)

    $url = "https://www.googleapis.com/oauth2/v4/token";

    $response = \Httpful\Request::post($url)
        ->body('grant_type=urn%3Aietf%3Aparams%3Aoauth%3Agrant-type%3Ajwt-bearer&assertion=' . $jwtAssertion)
        ->addHeaders(array(
            'Content-Type' => 'application/x-www-form-urlencoded',
        ))
        ->send();

    $access_token = $response->body->access_token;
dump($access_token);


    // 3. On accède au calendar via l'API

    // IMPORTANT ; pour accéder à un calendrier user, il doit être partagé avec l'email becowo@protean-keyword-132623.iam.gserviceaccount.com
    // cet email correspond au compte de service crée dans la console google de becowo@gmail.com
    $userCalendarID = "calendartestbecowo%40gmail.com";
    $url = "https://www.googleapis.com/calendar/v3/calendars/" . $userCalendarID . "/events";

    $response = \Httpful\Request::get($url)
        ->addHeader('Authorization', 'Bearer ' . $access_token)
        ->send();

dump($response);

    return $this->render('Debug/view.html.twig', array('content' => $content, 'contentToDump' => $contentToDump));

  }

  public function base64url_encode($data) { 
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');  
    //return strtr(base64_encode($data), '+/=', '-_,');
  }

}
