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
        $facebookId = $response->getUsername(); // bizarre mais username renvoi bien le Facebook Id
        $username = $response->getNickName();
        $user = $this->userManager->findUserByUsername($username);

        // if null just create new user and set it properties
        if (null === $user) {
            
            $user = $this->userManager->createUser();
            $user->setUsername($username);
            $user->setEnabled(true);
            $user->setEmail($response->getEmail());
            $user->setPassword("FacebookPwd");
            $user->setUpdatedAt( new \DateTime());
            $user->setFirstName($response->getFirstName());
            $user->setName($response->getRealName());
            $user->setFacebookId($facebookId);
            $user->setFacebookLink("https://www.facebook.com/".$facebookId);
            
            $profile_picture = new ProfilePicture();
            $profile_picture->setUrl($response->getProfilePicture());
            $profile_picture->setAlt($response->getFirstName());
            $user->setProfilePicture($profile_picture);

            return $user;
        }
        // else update access token of existing user
        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
        $user->$setter($response->getAccessToken());//update access token

        return $user;
    }
}
