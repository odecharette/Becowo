<?php

namespace Becowo\MemberBundle\Services;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseFOSUBProvider;
use Symfony\Component\Security\Core\User\UserInterface;
use Becowo\CoreBundle\Entity\ProfilePicture;

class MyFOSUBUserProvider extends BaseFOSUBProvider
{
    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        // get property from provider configuration by provider name
        // , it will return `facebook_id` in that case (see service definition below)
        $property = $this->getProperty($response);
        $username = $response->getUsername(); // get the unique user identifier

        //we "disconnect" previously connected users
        $existingUser = $this->userManager->findUserBy(array($property => $username));
        if (null !== $existingUser) {
            // set current user id and token to null for disconnect
            // ...

            $this->userManager->updateUser($existingUser);
        }
        // we connect current user, set current user id and token
        // ...
        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        dump($response);
        

        $service = $response->getResourceOwner()->getName();
        $infos = $response->getResponse();
        switch ($service) {
                case 'facebook':
                    $rsId = $infos['id'];
                    $email = $response->getEmail();
                    $user = $this->userManager->findUserBy(array('email' => $email));
                    break;
                case 'linkedin':
                    $rsId = $infos['id'];
                    $email = $infos['emailAddress'];
                    $user = $this->userManager->findUserBy(array('email' => $email));
                    break;
                case 'twitter':
                    $rsId = $infos['id_str'];
                    $user = $this->userManager->findUserBy(array('rsId' => $rsId));
                    break;
        }

        dump($user);
        // if null just create new user and set it properties
        if (null === $user) {
            
            $user = $this->userManager->createUser();
            $user->setUsername($response->getNickName());
            $user->setEnabled(true);
            $user->setPassword("RSPwd");
            $user->setUpdatedAt( new \DateTime());
            $user->setSignedUpWith($service);
            $user->setRsId($rsId);
            
            switch ($service) {
                case 'facebook':
                    $user->setEmail($email);
                    $user->setFacebookLink("https://www.facebook.com/".$rsId);
                    $user->setFirstName($response->getFirstName());
                    $user->setName($response->getRealName());
                    
                    $profile_picture = new ProfilePicture();
                    $profile_picture->setUrl($response->getProfilePicture());
                    $profile_picture->setAlt($response->getFirstName());
                    $user->setProfilePicture($profile_picture);
                    break;
                case 'linkedin':
                    $user->setEmail($email);
                    $user->setLinkedinLink($infos['publicProfileUrl']);
                    $user->setJob($infos['headline']);
                    $user->setCity($infos['location']['name']);
                    $user->setFirstName($infos['firstName']);
                    $user->setName($infos['lastName']);
                    $user->setSociety($infos['positions']['values'][0]['company']['name']);

                    $profile_picture = new ProfilePicture();
                    $profile_picture->setUrl($infos['pictureUrl']);
                    $profile_picture->setAlt($infos['firstName']);
                    $user->setProfilePicture($profile_picture);
                    break;
                case 'twitter':
                    $user->setTwitterLink('https://twitter.com/'.$infos['screen_name']);
                    $user->setName($infos['name']);

                    $profile_picture = new ProfilePicture();
                    $profile_picture->setUrl($infos['profile_image_url_https']);
                    $profile_picture->setAlt($infos['name']);
                    $user->setProfilePicture($profile_picture);
                    break;
            }

            return $user;
        }
        // else update access token of existing user
        // $serviceName = $response->getResourceOwner()->getName();
        // $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
        $user->setRsAccessToken($response->getAccessToken());//update access token

        return $user;
    }
}
