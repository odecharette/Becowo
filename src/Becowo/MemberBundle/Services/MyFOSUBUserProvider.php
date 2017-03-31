<?php

namespace Becowo\MemberBundle\Services;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseFOSUBProvider;
use Symfony\Component\Security\Core\User\UserInterface;
use Becowo\CoreBundle\Entity\ProfilePicture;
use Becowo\CoreBundle\Entity\Job;

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
        //dump($response);
        

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

      //  dump($user);
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
                    $user->setUrlProfilePicture($response->getProfilePicture());

                    break;
                case 'linkedin':
                    $user->setEmail($email);
                    $user->setLinkedinLink($infos['publicProfileUrl']);

                    $repo = $this->properties['em']->getRepository('BecowoCoreBundle:Job');
                    $linkedinJob = '';
                    if(isset($infos['positions']['values'][0]['title'])){
                        $linkedinJob = $infos['positions']['values'][0]['title'];
                    }
                    if($linkedinJob == ''){
                        if(isset($infos['headline'])){
                            $linkedinJob = $infos['headline'];
                        }
                    }
                    $existingJob = $repo->findOneBy(array('name' => $linkedinJob));

                    if($existingJob !== null)
                    {
                        $user->setJob($existingJob);
                    }else{
                        $job = new Job();
                        $job->setName($linkedinJob);
                        $user->setJob($job);
                        $this->properties['em']->persist($job);
                    }

                    if(isset($infos['location']['name'])){
                        $user->setCity($infos['location']['name']);
                    }
                    if(isset($infos['firstName'])){
                        $user->setFirstName($infos['firstName']);
                    }
                    if(isset($infos['lastName'])){
                        $user->setName($infos['lastName']);
                    }
                    if(isset($infos['positions']['values'][0]['company']['name'])){
                        $user->setSociety($infos['positions']['values'][0]['company']['name']);
                    }
                    if(isset($infos['positions']['values'][0]['summary'])){
                        $user->setDescription($infos['positions']['values'][0]['summary']);
                    }
                    if(isset($infos['pictureUrl'])){
                        $user->setUrlProfilePicture($infos['pictureUrl']);
                    }

                    break;
                case 'twitter':
                    $user->setTwitterLink('https://twitter.com/'.$infos['screen_name']);
                    $user->setName($infos['name']);
                    $user->setUrlProfilePicture($infos['profile_image_url_https']);

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
