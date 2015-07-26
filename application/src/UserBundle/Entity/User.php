<?php

namespace UserBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"user_professional" = "Application\Entity\ProfessionalUser",
 *  "user_client" = "Application\Entity\ClientUser"})
 */
abstract class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="biography", type="string", length=1000, nullable=true)
     */
    private $biography;

    /**
     * @var string
     *
     * @ORM\Column(name="address_1", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="address_2", type="string", length=255, nullable=true)
     */
    private $addressAdditional;

    /**
     * @var string
     *
     * @ORM\Column(name="county", type="string", length=255, nullable=true)
     */
    private $county;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=15, nullable=true)
     */
    private $postCode;

    /**
     * @var string
     *
     * @ORM\Column(name="user_type", nullable=true)
     */
    private $userType;

    /**
     * @var string
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $acceptedTos;

    /**
     * @var Media
     *
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"remove"})
     */
    private $profilePicture;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=8, nullable=true)
     */
    protected $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="timezone", type="string", length=64, nullable=true)
     */
    protected $timezone;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=64, nullable=true)
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_uid", type="string", length=255, nullable=true)
     */
    protected $facebookUid;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_name", type="string", length=255, nullable=true)
     */
    protected $facebookName;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_data", type="json", nullable=true)
     */
    protected $facebookData;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter_uid", type="string", length=255, nullable=true)
     */
    protected $twitterUid;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter_name", type="string", length=255, nullable=true)
     */
    protected $twitterName;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter_data", type="json", nullable=true)
     */
    protected $twitterData;

    /**
     * @var string
     *
     * @ORM\Column(name="gplus_uid", type="string", length=255, nullable=true)
     */
    protected $gplusUid;

    /**
     * @var string
     *
     * @ORM\Column(name="gplus_name", type="string", length=255, nullable=true)
     */
    protected $gplusName;

    /**
     * @var string
     *
     * @ORM\Column(name="gplus_data", type="json", nullable=true)
     */
    protected $gplusData;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     */
    protected $token;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set addressAdditional
     *
     * @param string $addressAdditional
     *
     * @return User
     */
    public function setAddressAdditional($addressAdditional)
    {
        $this->addressAdditional = $addressAdditional;

        return $this;
    }

    /**
     * Get addressAdditional
     *
     * @return string
     */
    public function getAddressAdditional()
    {
        return $this->addressAdditional;
    }

    /**
     * Set county
     *
     * @param string $county
     *
     * @return User
     */
    public function setCounty($county)
    {
        $this->county = $county;

        return $this;
    }

    /**
     * Get county
     *
     * @return string
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * Set postCode
     *
     * @param string $postCode
     *
     * @return User
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
     * @return string
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * @param string $userType
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;
    }

    /**
     * @return string
     */
    public function getAcceptedTos()
    {
        return $this->acceptedTos;
    }

    /**
     * @return Media
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * @param Media $profilePicture
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * @param string $biography
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getGplusData()
    {
        return $this->gplusData;
    }

    /**
     * @param string $gplusData
     */
    public function setGplusData($gplusData)
    {
        $this->gplusData = $gplusData;
    }

    /**
     * @return string
     */
    public function getGplusName()
    {
        return $this->gplusName;
    }

    /**
     * @param string $gplusName
     */
    public function setGplusName($gplusName)
    {
        $this->gplusName = $gplusName;
    }

    /**
     * @return string
     */
    public function getGplusUid()
    {
        return $this->gplusUid;
    }

    /**
     * @param string $gplusUid
     */
    public function setGplusUid($gplusUid)
    {
        $this->gplusUid = $gplusUid;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param string $timezone
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getFacebookUid()
    {
        return $this->facebookUid;
    }

    /**
     * @param string $facebookUid
     */
    public function setFacebookUid($facebookUid)
    {
        $this->facebookUid = $facebookUid;
    }

    /**
     * @return string
     */
    public function getFacebookName()
    {
        return $this->facebookName;
    }

    /**
     * @param string $facebookName
     */
    public function setFacebookName($facebookName)
    {
        $this->facebookName = $facebookName;
    }

    /**
     * @return string
     */
    public function getTwitterUid()
    {
        return $this->twitterUid;
    }

    /**
     * @param string $twitterUid
     */
    public function setTwitterUid($twitterUid)
    {
        $this->twitterUid = $twitterUid;
    }

    /**
     * @return string
     */
    public function getTwitterName()
    {
        return $this->twitterName;
    }

    /**
     * @param string $twitterName
     */
    public function setTwitterName($twitterName)
    {
        $this->twitterName = $twitterName;
    }

    /**
     * @return string
     */
    public function getTwitterData()
    {
        return $this->twitterData;
    }

    /**
     * @param string $twitterData
     */
    public function setTwitterData($twitterData)
    {
        $this->twitterData = $twitterData;
    }

    /**
     * @param string $acceptedTos
     */
    public function setAcceptedTos($acceptedTos)
    {
        $this->acceptedTos = $acceptedTos;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        $this->username = $email;
    }

    public function setEmailCanonical($emailCanonical)
    {
        $this->emailCanonical = $emailCanonical;
        $this->usernameCanonical = $emailCanonical;
    }
}
