<?php

namespace Becowo\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Algolia\AlgoliaSearchBundle\Mapping\Annotation as Algolia;
use Doctrine\Common\Collections\ArrayCollection;
use Becowo\CoreBundle\Entity\Skill;
use Becowo\CoreBundle\Entity\Hobbie;
use Becowo\CoreBundle\Entity\Wish;
use Doctrine\ORM\PersistentCollection;

/**
 * Member
 *
 * @ORM\Table(name="becowo_member", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"}), @ORM\UniqueConstraint(name="email_UNIQUE", columns={"email"}), @ORM\UniqueConstraint(name="username_UNIQUE", columns={"username"})}, indexes={@ORM\Index(name="fk_country_id_idx", columns={"country_id"}), @ORM\Index(name="fk_origin_id_idx", columns={"origin_id"})})
 * @ORM\AttributeOverrides({
 *              @ORM\AttributeOverride(name="email", column=@ORM\Column(nullable=true)),
 *              @ORM\AttributeOverride(name="emailCanonical", column=@ORM\Column(nullable=true))})
 * @ORM\Entity(repositoryClass="Becowo\MemberBundle\Repository\MemberRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Member extends BaseUser
{
    
/***** Liste des attributs déjà hérités/gérés par FOSUserBundle
username : nom d'utilisateur avec lequel l'utilisateur va s'identifier ;
email : l'adresse e-mail ;
enabled : true ou false suivant que l'inscription de l'utilisateur a été validée ou non (dans le cas d'une confirmation par e-mail par exemple) ;
password : le mot de passe de l'utilisateur ;
lastLogin : la date de la dernière connexion ;
locked : si vous voulez désactiver des comptes ;
expired : si vous voulez que les comptes expirent au-delà d'une certaine durée.
+ roles
+ salt

**************/

     /**
       * @ORM\Column(name="id", type="integer")
       * @ORM\Id
       * @ORM\GeneratedValue(strategy="AUTO")
       * @Algolia\Attribute
       */
      protected $id;

   

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=50, nullable=true)
     * @Assert\Length(min = 3, max = 25)
     * @Algolia\Attribute
     *
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     * @Assert\Length(min = 3, max = 30)
     * @Algolia\Attribute
     *
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sex", type="string", length=1, nullable=true)
     */
    private $sex;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=10, nullable=true)
     * @Assert\Length(min = 10, max = 10)
     * @Assert\Regex(pattern="/\A0\d{9}/", message="Le N° doit commencer par zéro et ne contenir que des chiffres")
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=500, nullable=true)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="post_code", type="string", length=5, nullable=true)
     * @Assert\Regex(pattern="/\d{5}/", message="Le code postal doit contenir 5 chiffres")
     */
    private $postCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50, nullable=true)
     * @Algolia\Attribute
     *
     */
    private $city;

    /**
     * @var \Becowo\CoreBundle\Entity\Job
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Job")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     * })
     * @Algolia\Attribute
     */
    private $job;

    /**
     * @var string
     *
     * @ORM\Column(name="society", type="string", length=100, nullable=true)
     * @Assert\Length(min = 3, max = 100)
     *
     */
    private $society;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     *
     * @Assert\Regex("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i")
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Algolia\Attribute
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sign_up_date", type="datetime", nullable=true)
     */
    private $signUpDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_deleted", type="boolean", nullable=false)
     */
    private $isDeleted = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="signed_up_with", type="string", length=45, nullable=true)
     */
    private $signedUpWith;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_link", type="string", length=255, nullable=true)
     *
     * @Assert\Regex("/\b(?:(?:https?|ftp):\/\/|(www|facebook)\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i")
     */
    private $facebookLink;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter_link", type="string", length=255, nullable=true)
     *
     * @Assert\Regex("/\b(?:(?:https?|ftp):\/\/|(www|twitter)\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i")
     */
    private $twitterLink;

    /**
     * @var string
     *
     * @ORM\Column(name="instagram_link", type="string", length=255, nullable=true)
     *
     * @Assert\Regex("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i")
     */
    private $instagramLink;

    /**
     * @var string
     *
     * @ORM\Column(name="linkedin_link", type="string", length=255, nullable=true)
     *
     * @Assert\Regex("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i")
     */
    private $linkedinLink;

    /**
     * @var string
     *
     * @ORM\Column(name="url_profile_picture", type="string", length=255, nullable=true)
     * @Algolia\Attribute
     */
    private $urlProfilePicture;

    /**
     * @var \Becowo\CoreBundle\Entity\Origin
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Origin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="origin_id", referencedColumnName="id")
     * })
     */
    private $origin;

    /**
     * @var \Becowo\CoreBundle\Entity\Country
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Country")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     * })
     */
    private $country;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToOne(targetEntity="Becowo\CoreBundle\Entity\Workspace")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="workspace_id", referencedColumnName="id")
     * })
     */
    private $workspace;

    /**
     * @ORM\Column(name="rs_id", type="string", length=255, nullable=true)
     */
    private $rsId;

    private $rsAccessToken;

    /**
     * @var string
     *
     * @ORM\Column(name="personnal_tweet", type="string", length=140, nullable=true)
     * @Assert\Length(max = 140)
     */
    private $personnalTweet;

    /**
     * @var string
     *
     * @ORM\Column(name="fill_rate", type="float", precision=3, scale=0, nullable=true)
     * @Algolia\Attribute
     */
    private $fillRate;


    /**
     * @var boolean
     *
     * @ORM\Column(name="has_received_email_new_user", type="boolean", nullable=false)
     */
    private $hasReceivedEmailNewUser = '0';


    /**
     * @var boolean
     *
     * @ORM\Column(name="email_is_public", type="boolean", nullable=false)
     */
    private $emailIsPublic = '0';

    private $file;

    /**
    * @ORM\ManyToMany(targetEntity="Becowo\CoreBundle\Entity\Skill", cascade={"persist"}, fetch="EAGER")
    * @Algolia\Attribute
    */
    private $listSkills;

    /**
    * @ORM\ManyToMany(targetEntity="Becowo\CoreBundle\Entity\Hobbie", cascade={"persist"}, fetch="EAGER")
    * @Algolia\Attribute
    */
    private $listHobbies;

    /**
    * @ORM\ManyToMany(targetEntity="Becowo\CoreBundle\Entity\Wish", cascade={"persist"}, fetch="EAGER")
    * @Algolia\Attribute
    */
    private $listWishes;
  
  public function getFile()
  {
    return $this->file;
  }

  public function setFile(UploadedFile $file = null)
  {
    $this->file = $file;
  }


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->createdAt = new \DateTime();
        $this->roles = ['ROLE_USER'];
        $this->listSkills = new ArrayCollection();
        $this->listHobbies = new ArrayCollection();
        $this->listWishes = new ArrayCollection();
    }


    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return Member
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return Member
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return string
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Member
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Member
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set sex
     *
     * @param boolean $sex
     *
     * @return Member
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return boolean
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Member
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Member
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Member
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set postCode
     *
     * @param string $postCode
     *
     * @return Member
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
     * Get postCode
     *
     * @return string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Member
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set job
     *
     * @param string $job
     *
     * @return Member
     */
    public function setJob(\Becowo\CoreBundle\Entity\Job $job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set society
     *
     * @param string $society
     *
     * @return Member
     */
    public function setSociety($society)
    {
        $this->society = $society;

        return $this;
    }

    /**
     * Get society
     *
     * @return string
     */
    public function getSociety()
    {
        return $this->society;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return Member
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Member
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set signUpDate
     *
     * @param \DateTime $signUpDate
     *
     * @return Member
     */
    public function setSignUpDate($signUpDate)
    {
        $this->signUpDate = $signUpDate;

        return $this;
    }

    /**
     * Get signUpDate
     *
     * @return \DateTime
     */
    public function getSignUpDate()
    {
        return $this->signUpDate;
    }

    

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Member
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Member
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return Member
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return boolean
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set signedUpWith
     *
     * @param string $signedUpWith
     *
     * @return Member
     */
    public function setSignedUpWith($signedUpWith)
    {
        $this->signedUpWith = $signedUpWith;

        return $this;
    }

    /**
     * Get signedUpWith
     *
     * @return string
     */
    public function getSignedUpWith()
    {
        return $this->signedUpWith;
    }

    
    /**
     * Set facebookLink
     *
     * @param string $facebookLink
     *
     * @return Member
     */
    public function setFacebookLink($facebookLink)
    {
        $this->facebookLink = $facebookLink;

        return $this;
    }

    /**
     * Get facebookLink
     *
     * @return string
     */
    public function getFacebookLink()
    {
        return $this->facebookLink;
    }

    /**
     * Set twitterLink
     *
     * @param string $twitterLink
     *
     * @return Member
     */
    public function setTwitterLink($twitterLink)
    {
        $this->twitterLink = $twitterLink;

        return $this;
    }

    /**
     * Get twitterLink
     *
     * @return string
     */
    public function getTwitterLink()
    {
        return $this->twitterLink;
    }

    /**
     * Set instagramLink
     *
     * @param string $instagramLink
     *
     * @return Member
     */
    public function setInstagramLink($instagramLink)
    {
        $this->instagramLink = $instagramLink;

        return $this;
    }

    /**
     * Get instagramLink
     *
     * @return string
     */
    public function getInstagramLink()
    {
        return $this->instagramLink;
    }

    /**
     * Set linkedinLink
     *
     * @param string $linkedinLink
     *
     * @return Member
     */
    public function setLinkedinLink($linkedinLink)
    {
        $this->linkedinLink = $linkedinLink;

        return $this;
    }

    /**
     * Get linkedinLink
     *
     * @return string
     */
    public function getLinkedinLink()
    {
        return $this->linkedinLink;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set urlProfilePicture
     *
     * @param string $urlProfilePicture
     *
     * @return Member
     */
    public function setUrlProfilePicture($urlProfilePicture)
    {
        $this->urlProfilePicture = $urlProfilePicture;

        return $this;
    }

    /**
     * Get urlProfilePicture
     *
     * @return string
     */
    public function getUrlProfilePicture()
    {
        return $this->urlProfilePicture;
    }

    /**
     * Set origin
     *
     * @param \Becowo\CoreBundle\Entity\Origin $origin
     *
     * @return Member
     */
    public function setOrigin(\Becowo\CoreBundle\Entity\Origin $origin = null)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * Get origin
     *
     * @return \Becowo\CoreBundle\Entity\Origin
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * Set country
     *
     * @param \Becowo\CoreBundle\Entity\Country $country
     *
     * @return Member
     */
    public function setCountry(\Becowo\CoreBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Becowo\CoreBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }


    /**
     * Get workspace
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkspace()
    {
        return $this->workspace;
    }

    /**
     * Set workspace
     *
     * @param \Becowo\CoreBundle\Entity\Workspace $workspace
     *
     * @return Member
     */
    public function setWorkspace(\Becowo\CoreBundle\Entity\Workspace $workspace = null)
    {
        $this->workspace = $workspace;

        return $this;
    }

    public function eraseCredentials()
  {
  }

    /**
     * Set PlainPassword
     *
     * @param $password
     *
     * @return Member
     */
      public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
        $this->updatedAt = new \DateTime();

        return $this;
    }

    /**
     * @param string $rsId
     * @return User
     */
    public function setRsId($rsId)
    {
        $this->rsId = $rsId;

        return $this;
    }

    /**
     * @return string
     */
    public function getRsId()
    {
        return $this->rsId;
    }

    /**
     * @param string $facebookAccessToken
     * @return User
     */
    public function setRsAccessToken($rsAccessToken)
    {
        $this->rsAccessToken = $rsAccessToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getRsAccessToken()
    {
        return $this->rsAccessToken;
    }


    /**
     * Gets the value of personnalTweet.
     *
     * @return string
     */
    public function getPersonnalTweet()
    {
        return $this->personnalTweet;
    }

    /**
     * Sets the value of personnalTweet.
     *
     * @param string $personnalTweet the personnal tweet
     *
     * @return self
     */
    public function setPersonnalTweet($personnalTweet)
    {
        $this->personnalTweet = $personnalTweet;

        return $this;
    }

    /**
     * Gets the value of fillRate.
     *
     * @return string
     */
    public function getFillRate()
    {
        return $this->fillRate;
    }

    /**
     * Sets the value of fillRate.
     *
     * @param string $fillRate the fill rate
     *
     * @return self
     */
    public function setFillRate($fillRate)
    {
        $this->fillRate = $fillRate;

        return $this;
    }


    /**
     * Gets the value of hasReceivedEmailNewUser.
     *
     * @return boolean
     */
    public function getHasReceivedEmailNewUser()
    {
        return $this->hasReceivedEmailNewUser;
    }

    /**
     * Sets the value of hasReceivedEmailNewUser.
     *
     * @param boolean $hasReceivedEmailNewUser the has received email new user
     *
     * @return self
     */
    public function setHasReceivedEmailNewUser($hasReceivedEmailNewUser)
    {
        $this->hasReceivedEmailNewUser = $hasReceivedEmailNewUser;

        return $this;
    }


    /**
     * Gets the value of emailIsPublic.
     *
     * @return boolean
     */
    public function getEmailIsPublic()
    {
        return $this->emailIsPublic;
    }

    /**
     * Sets the value of emailIsPublic.
     *
     * @param boolean $emailIsPublic the has received email new user
     *
     * @return self
     */
    public function setEmailIsPublic($emailIsPublic)
    {
        $this->emailIsPublic = $emailIsPublic;

        return $this;
    }

    public function getFullName()
    {
        return $this->firstname . ' ' . $this->name;
    }

    
    // Cette méthode est utilisée quand le CollectionToSkillTransformer renvoi une ArrayCollection de skills
    public function setListSkills(ArrayCollection $collectionSkills)
    {
        //Si la skill n'est pas déjà liée au member, on l'ajoute
        foreach($collectionSkills as $s)
        {
            if(! $this->getListSkills()->contains($s)){
                $this->addListSkill($s);
            }
        }

        // Si une skill n'est plus mentionnée, on la supprime
        foreach($this->getListSkills() as $ss)
        {
            if(! $collectionSkills->contains($ss)){
                $this->removeListSkills($ss);
            }
        }
    }

    public function addListSkill(Skill $skill)
    {
        
        $this->listSkills[] = $skill;
    }

    public function removeListSkills(Skill $skill)
    {
        $this->listSkills->removeElement($skill);
    }

    public function getListSkills()
    {
        return $this->listSkills;
    }

    public function addHobbie(Hobbie $hobbie)
    {
        $this->listHobbies[] = $hobbie;
    }

    public function removeHobbie(Hobbie $hobbie)
    {
        $this->listHobbies->removeElement($hobbie);
    }

    public function getlistHobbies()
    {
        return $this->listHobbies;
    }

    // Cette méthode est utilisée quand le CollectionToSkillTransformer renvoi une ArrayCollection de Hobbies
    public function setListHobbies(ArrayCollection $collectionHobbies)
    {
        //Si la hobbie n'est pas déjà liée au member, on l'ajoute
        foreach($collectionHobbies as $s)
        {
            if(! $this->getlistHobbies()->contains($s)){
                $this->addHobbie($s);
            }
        }

        // Si un hobbie n'est plus mentionnée, on le supprime
        foreach($this->getlistHobbies() as $ss)
        {
            if(! $collectionHobbies->contains($ss)){
                $this->removeHobbie($ss);
            }
        }
    }

    public function addWish(Wish $wish)
    {
        $this->listWishes[] = $wish;
    }

    public function removeWish(Wish $wish)
    {
        $this->listWishes->removeElement($wish);
    }

    public function getlistWishes()
    {
        return $this->listWishes;
    }

    // Cette méthode est utilisée quand le CollectionToSkillTransformer renvoi une ArrayCollection de Wishes
    public function setListWishes(ArrayCollection $collectionWishes)
    {
        //Si la hobbie n'est pas déjà liée au member, on l'ajoute
        foreach($collectionWishes as $s)
        {
            if(! $this->getlistWishes()->contains($s)){
                $this->addWish($s);
            }
        }

        // Si un hobbie n'est plus mentionnée, on le supprime
        foreach($this->getlistWishes() as $ss)
        {
            if(! $collectionWishes->contains($ss)){
                $this->removeWish($ss);
            }
        }
    }

    /**
     * @Algolia\IndexIf
     */
    public function isVisible()
    {
        return !$this->isDeleted && $this->enabled && $this->job != '';
    }


    /**
     * @ORM\PreUpdate
     */
    public function updateFillRate()
    {
        $totalInfo = 22;
        $totalFilled = 0;

        $this->getFirstname() != '' ? $totalFilled++ : '';
        $this->getName() != '' ? $totalFilled++ : '';
        $this->getSex() != '' ? $totalFilled++ : '';
        $this->getBirthDate() != '' ? $totalFilled++ : '';
        $this->getPhone() != '' ? $totalFilled++ : '';
        $this->getStreet() != '' ? $totalFilled++ : '';
        $this->getPostCode() != '' ? $totalFilled++ : '';
        $this->getCity() != '' ? $totalFilled++ : '';
        $this->getJob() != '' ? $totalFilled++ : '';
        $this->getSociety() != '' ? $totalFilled++ : '';
        $this->getWebsite() != '' ? $totalFilled++ : '';
        $this->getDescription() != '' ? $totalFilled++ : '';
        $this->getFacebookLink() != '' ? $totalFilled++ : '';
        $this->getTwitterLink() != '' ? $totalFilled++ : '';
        $this->getInstagramLink() != '' ? $totalFilled++ : '';
        $this->getLinkedinLink() != '' ? $totalFilled++ : '';
        $this->getUrlProfilePicture() != '' ? $totalFilled++ : '';
        $this->getCountry() != '' ? $totalFilled++ : '';
        $this->getPersonnalTweet() != '' ? $totalFilled++ : '';
        $this->getListSkills()->count() > 0 ? $totalFilled++ : '';
        $this->getlistHobbies()->count() > 0 ? $totalFilled++ : '';
        $this->getlistWishes()->count() > 0 ? $totalFilled++ : '';

        $this->setFillRate(round($totalFilled / $totalInfo * 100, 0));
    }
}
