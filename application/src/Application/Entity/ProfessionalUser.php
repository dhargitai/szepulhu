<?php

namespace Application\Entity;

use Application\Entity\Professional\Salon;
use Application\Model\Professional;
use Application\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Symfony\Component\Validator\Constraints as Assert;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;

/**
 * ProfessionalUser
 *
 * @ORM\Table(name="user_professional")
 * @ORM\Entity(repositoryClass="Application\Entity\ProfessionalUserRepository")
 * @UniqueEntity(fields = "username", targetClass = "Application\UserBundle\Entity\User", message="fos_user.username.already_used", groups={"flow_registerProfessionalFlow_step1"})
 * @UniqueEntity(fields = "email", targetClass = "Application\UserBundle\Entity\User", message="fos_user.email.already_used", groups={"flow_registerProfessionalFlow_step1"})
 */
class ProfessionalUser extends User implements Professional
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
     * @ORM\Column(name="slug", type="string", length=255, unique=true, nullable=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=64)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=64)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="profession", type="string", length=128, nullable=true)
     */
    private $profession;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255, nullable=true)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_page", type="string", length=255, nullable=true)
     */
    private $facebookPage;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter_account", type="string", length=100, nullable=true)
     */
    private $twitterAccount;

    /**
     * @var string
     *
     * @ORM\Column(name="blog_page", type="string", length=255, nullable=true)
     */
    private $blogPage;

    /**
     * @var integer
     *
     * @ORM\Column(name="price_category", type="smallint", nullable=true)
     */
    private $priceCategory;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_premium", type="boolean", nullable=true)
     */
    private $isPremium = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="setting_online_booking", type="boolean", nullable=true)
     */
    private $settingOnlineBooking;

    /**
     * @var boolean
     *
     * @ORM\Column(name="setting_creditcard_for_booking", type="boolean", nullable=true)
     */
    private $settingCreditcardForBooking;

    /**
     * @var boolean
     *
     * @ORM\Column(name="setting_book_multiple", type="boolean", nullable=true)
     */
    private $settingBookMultiple;

    /**
     * @var boolean
     *
     * @ORM\Column(name="setting_notice_for_booking", type="boolean", nullable=true)
     */
    private $settingNoticeForBooking;

    /**
     * @var boolean
     *
     * @ORM\Column(name="setting_notice_for_cancellation", type="boolean", nullable=true)
     */
    private $settingNoticeForCancellation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="setting_show_last_minute", type="boolean", nullable=true)
     */
    private $settingShowLastMinute;

    /**
     * @var string
     *
     * @ORM\Column(name="setting_cancellation_policy", type="text", nullable=true)
     */
    private $settingCancellationPolicy;

    /**
     * @var boolean
     *
     * @ORM\Column(name="setting_sms_on_booking_send", type="boolean", nullable=true)
     */
    private $settingSmsOnBookingSend;

    /**
     * @var string
     *
     * @ORM\Column(name="setting_sms_on_booking_phone", type="string", length=255, nullable=true)
     */
    private $settingSmsOnBookingPhone;

    /**
     * @var integer
     *
     * @ORM\Column(name="setting_sms_on_booking_from_hour", type="smallint", nullable=true)
     */
    private $settingSmsOnBookingFromHour;

    /**
     * @var integer
     *
     * @ORM\Column(name="setting_sms_on_booking_to_hour", type="smallint", nullable=true)
     */
    private $settingSmsOnBookingToHour;

    /**
     * @var boolean
     *
     * @ORM\Column(name="setting_schedule_notification", type="boolean", nullable=true)
     */
    private $settingScheduleNotification;

    /**
     * @var boolean
     *
     * @ORM\Column(name="setting_client_reminder_send", type="boolean", nullable=true)
     */
    private $settingClientReminderSend;

    /**
     * @var integer
     *
     * @ORM\Column(name="setting_client_reminder_before_days", type="smallint", nullable=true)
     */
    private $settingClientReminderBeforeDays;

    /**
     * @var string
     *
     * @ORM\Column(name="setting_client_reminder_text_message", type="text", nullable=true)
     */
    private $settingClientReminderTextMessage;

    /**
     * @var string
     *
     * @ORM\Column(name="setting_client_reminder_phone", type="string", length=255, nullable=true)
     */
    private $settingClientReminderPhone;

    /**
     * @var boolean
     *
     * @ORM\Column(name="setting_client_thankyou", type="boolean", nullable=true)
     */
    private $settingClientThankyou;

    /**
     * @var boolean
     *
     * @ORM\Column(name="setting_client_missyou", type="boolean", nullable=true)
     */
    private $settingClientMissyou;

    /**
     * @var boolean
     *
     * @ORM\Column(name="setting_receive_daily_stats", type="boolean", nullable=true)
     */
    private $settingReceiveDailyStats;

    /**
     * @var boolean
     *
     * @ORM\Column(name="setting_receive_weekly_stats", type="boolean", nullable=true)
     */
    private $settingReceiveWeeklyStats;

    /**
     * @var string
     *
     * @ORM\Column(name="setting_service_tax", type="decimal", nullable=true)
     */
    private $settingServiceTax;

    /**
     * @var string
     *
     * @ORM\Column(name="setting_product_tax", type="decimal", nullable=true)
     */
    private $settingProductTax;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="featured_from", type="date", nullable=true)
     */
    private $featuredFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="featured_to", type="date", nullable=true)
     */
    private $featuredTo;

    /**
     * @var array
     *
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $interests;

    /**
     * @var string
     *
     * @ORM\Column(name="preferred_phone_on_profile", type="text", nullable=true)
     */
    private $preferredPhoneOnProfile = Professional::PREFERRED_PHONE_PERSONAL;

    /**
     * @var Gallery
     *
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery", cascade={"remove"})
     */
    private $gallery;

    /**
     * @var Salon
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Professional\Salon", inversedBy="professionals", cascade={"persist"})
     */
    private $salon;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\Entity\Professional\ServiceGroup", mappedBy="professional", cascade={"remove"})
     */
    private $serviceGroups;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\Entity\Professional\Recommendation", mappedBy="professional", cascade={"remove"})
     */
    private $recommendations;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Application\Entity\Professional\Task", inversedBy="professionals")
     */
    private $tasks;

    public function __construct()
    {
        parent::__construct();

        $this->serviceGroups = new ArrayCollection();
        $this->recommendations = new ArrayCollection();
        $this->tasks = new ArrayCollection();
    }

    public static function getSalonRoles()
    {
        return array(
            'contractor' => 'form.professional.role.contractor',
            'employee' => 'form.professional.role.employee',
            'owner' => 'form.professional.role.owner',
        );
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
     * Set profession
     *
     * @param string $profession
     *
     * @return ProfessionalUser
     */
    public function setProfession($profession)
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * Get profession
     *
     * @return string
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return ProfessionalUser
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set priceCategory
     *
     * @param integer $priceCategory
     *
     * @return ProfessionalUser
     */
    public function setPriceCategory($priceCategory)
    {
        $this->priceCategory = $priceCategory;

        return $this;
    }

    /**
     * Get priceCategory
     *
     * @return integer
     */
    public function getPriceCategory()
    {
        return $this->priceCategory;
    }

    /**
     * Set isPremium
     *
     * @param boolean $isPremium
     *
     * @return ProfessionalUser
     */
    public function setIsPremium($isPremium)
    {
        $this->isPremium = $isPremium;

        return $this;
    }

    /**
     * Get isPremium
     *
     * @return boolean
     */
    public function getIsPremium()
    {
        return $this->isPremium;
    }

    /**
     * Set settingOnlineBooking
     *
     * @param boolean $settingOnlineBooking
     *
     * @return ProfessionalUser
     */
    public function setSettingOnlineBooking($settingOnlineBooking)
    {
        $this->settingOnlineBooking = $settingOnlineBooking;

        return $this;
    }

    /**
     * Get settingOnlineBooking
     *
     * @return boolean
     */
    public function getSettingOnlineBooking()
    {
        return $this->settingOnlineBooking;
    }

    /**
     * Set settingCreditcardForBooking
     *
     * @param boolean $settingCreditcardForBooking
     *
     * @return ProfessionalUser
     */
    public function setSettingCreditcardForBooking($settingCreditcardForBooking)
    {
        $this->settingCreditcardForBooking = $settingCreditcardForBooking;

        return $this;
    }

    /**
     * Get settingCreditcardForBooking
     *
     * @return boolean
     */
    public function getSettingCreditcardForBooking()
    {
        return $this->settingCreditcardForBooking;
    }

    /**
     * Set settingBookMultiple
     *
     * @param boolean $settingBookMultiple
     *
     * @return ProfessionalUser
     */
    public function setSettingBookMultiple($settingBookMultiple)
    {
        $this->settingBookMultiple = $settingBookMultiple;

        return $this;
    }

    /**
     * Get settingBookMultiple
     *
     * @return boolean
     */
    public function getSettingBookMultiple()
    {
        return $this->settingBookMultiple;
    }

    /**
     * Set settingNoticeForBooking
     *
     * @param boolean $settingNoticeForBooking
     *
     * @return ProfessionalUser
     */
    public function setSettingNoticeForBooking($settingNoticeForBooking)
    {
        $this->settingNoticeForBooking = $settingNoticeForBooking;

        return $this;
    }

    /**
     * Get settingNoticeForBooking
     *
     * @return boolean
     */
    public function getSettingNoticeForBooking()
    {
        return $this->settingNoticeForBooking;
    }

    /**
     * Set settingNoticeForCancellation
     *
     * @param boolean $settingNoticeForCancellation
     *
     * @return ProfessionalUser
     */
    public function setSettingNoticeForCancellation($settingNoticeForCancellation)
    {
        $this->settingNoticeForCancellation = $settingNoticeForCancellation;

        return $this;
    }

    /**
     * Get settingNoticeForCancellation
     *
     * @return boolean
     */
    public function getSettingNoticeForCancellation()
    {
        return $this->settingNoticeForCancellation;
    }

    /**
     * Set settingShowLastMinute
     *
     * @param boolean $settingShowLastMinute
     *
     * @return ProfessionalUser
     */
    public function setSettingShowLastMinute($settingShowLastMinute)
    {
        $this->settingShowLastMinute = $settingShowLastMinute;

        return $this;
    }

    /**
     * Get settingShowLastMinute
     *
     * @return boolean
     */
    public function getSettingShowLastMinute()
    {
        return $this->settingShowLastMinute;
    }

    /**
     * Set settingCancellationPolicy
     *
     * @param string $settingCancellationPolicy
     *
     * @return ProfessionalUser
     */
    public function setSettingCancellationPolicy($settingCancellationPolicy)
    {
        $this->settingCancellationPolicy = $settingCancellationPolicy;

        return $this;
    }

    /**
     * Get settingCancellationPolicy
     *
     * @return string
     */
    public function getSettingCancellationPolicy()
    {
        return $this->settingCancellationPolicy;
    }

    /**
     * Set settingSmsOnBookingSend
     *
     * @param boolean $settingSmsOnBookingSend
     *
     * @return ProfessionalUser
     */
    public function setSettingSmsOnBookingSend($settingSmsOnBookingSend)
    {
        $this->settingSmsOnBookingSend = $settingSmsOnBookingSend;

        return $this;
    }

    /**
     * Get settingSmsOnBookingSend
     *
     * @return boolean
     */
    public function getSettingSmsOnBookingSend()
    {
        return $this->settingSmsOnBookingSend;
    }

    /**
     * Set settingSmsOnBookingPhone
     *
     * @param string $settingSmsOnBookingPhone
     *
     * @return ProfessionalUser
     */
    public function setSettingSmsOnBookingPhone($settingSmsOnBookingPhone)
    {
        $this->settingSmsOnBookingPhone = $settingSmsOnBookingPhone;

        return $this;
    }

    /**
     * Get settingSmsOnBookingPhone
     *
     * @return string
     */
    public function getSettingSmsOnBookingPhone()
    {
        return $this->settingSmsOnBookingPhone;
    }

    /**
     * Set settingSmsOnBookingFromHour
     *
     * @param integer $settingSmsOnBookingFromHour
     *
     * @return ProfessionalUser
     */
    public function setSettingSmsOnBookingFromHour($settingSmsOnBookingFromHour)
    {
        $this->settingSmsOnBookingFromHour = $settingSmsOnBookingFromHour;

        return $this;
    }

    /**
     * Get settingSmsOnBookingFromHour
     *
     * @return integer
     */
    public function getSettingSmsOnBookingFromHour()
    {
        return $this->settingSmsOnBookingFromHour;
    }

    /**
     * Set settingSmsOnBookingToHour
     *
     * @param integer $settingSmsOnBookingToHour
     *
     * @return ProfessionalUser
     */
    public function setSettingSmsOnBookingToHour($settingSmsOnBookingToHour)
    {
        $this->settingSmsOnBookingToHour = $settingSmsOnBookingToHour;

        return $this;
    }

    /**
     * Get settingSmsOnBookingToHour
     *
     * @return integer
     */
    public function getSettingSmsOnBookingToHour()
    {
        return $this->settingSmsOnBookingToHour;
    }

    /**
     * Set settingScheduleNotification
     *
     * @param boolean $settingScheduleNotification
     *
     * @return ProfessionalUser
     */
    public function setSettingScheduleNotification($settingScheduleNotification)
    {
        $this->settingScheduleNotification = $settingScheduleNotification;

        return $this;
    }

    /**
     * Get settingScheduleNotification
     *
     * @return boolean
     */
    public function getSettingScheduleNotification()
    {
        return $this->settingScheduleNotification;
    }

    /**
     * Set settingClientReminderSend
     *
     * @param boolean $settingClientReminderSend
     *
     * @return ProfessionalUser
     */
    public function setSettingClientReminderSend($settingClientReminderSend)
    {
        $this->settingClientReminderSend = $settingClientReminderSend;

        return $this;
    }

    /**
     * Get settingClientReminderSend
     *
     * @return boolean
     */
    public function getSettingClientReminderSend()
    {
        return $this->settingClientReminderSend;
    }

    /**
     * Set settingClientReminderBeforeDays
     *
     * @param integer $settingClientReminderBeforeDays
     *
     * @return ProfessionalUser
     */
    public function setSettingClientReminderBeforeDays($settingClientReminderBeforeDays)
    {
        $this->settingClientReminderBeforeDays = $settingClientReminderBeforeDays;

        return $this;
    }

    /**
     * Get settingClientReminderBeforeDays
     *
     * @return integer
     */
    public function getSettingClientReminderBeforeDays()
    {
        return $this->settingClientReminderBeforeDays;
    }

    /**
     * Set settingClientReminderTextMessage
     *
     * @param string $settingClientReminderTextMessage
     *
     * @return ProfessionalUser
     */
    public function setSettingClientReminderTextMessage($settingClientReminderTextMessage)
    {
        $this->settingClientReminderTextMessage = $settingClientReminderTextMessage;

        return $this;
    }

    /**
     * Get settingClientReminderSmsText
     *
     * @return string
     */
    public function getSettingClientReminderTextMessage()
    {
        return $this->settingClientReminderTextMessage;
    }

    /**
     * Set settingClientReminderPhone
     *
     * @param string $settingClientReminderPhone
     *
     * @return ProfessionalUser
     */
    public function setSettingClientReminderPhone($settingClientReminderPhone)
    {
        $this->settingClientReminderPhone = $settingClientReminderPhone;

        return $this;
    }

    /**
     * Get settingClientReminderPhone
     *
     * @return string
     */
    public function getSettingClientReminderPhone()
    {
        return $this->settingClientReminderPhone;
    }

    /**
     * Set settingClientThankyou
     *
     * @param boolean $settingClientThankyou
     *
     * @return ProfessionalUser
     */
    public function setSettingClientThankyou($settingClientThankyou)
    {
        $this->settingClientThankyou = $settingClientThankyou;

        return $this;
    }

    /**
     * Get settingClientThankyou
     *
     * @return boolean
     */
    public function getSettingClientThankyou()
    {
        return $this->settingClientThankyou;
    }

    /**
     * Set settingClientMissyou
     *
     * @param boolean $settingClientMissyou
     *
     * @return ProfessionalUser
     */
    public function setSettingClientMissyou($settingClientMissyou)
    {
        $this->settingClientMissyou = $settingClientMissyou;

        return $this;
    }

    /**
     * Get settingClientMissyou
     *
     * @return boolean
     */
    public function getSettingClientMissyou()
    {
        return $this->settingClientMissyou;
    }

    /**
     * Set settingReceiveDailyStats
     *
     * @param boolean $settingReceiveDailyStats
     *
     * @return ProfessionalUser
     */
    public function setSettingReceiveDailyStats($settingReceiveDailyStats)
    {
        $this->settingReceiveDailyStats = $settingReceiveDailyStats;

        return $this;
    }

    /**
     * Get settingReceiveDailyStats
     *
     * @return boolean
     */
    public function getSettingReceiveDailyStats()
    {
        return $this->settingReceiveDailyStats;
    }

    /**
     * Set settingReceiveWeeklyStats
     *
     * @param boolean $settingReceiveWeeklyStats
     *
     * @return ProfessionalUser
     */
    public function setSettingReceiveWeeklyStats($settingReceiveWeeklyStats)
    {
        $this->settingReceiveWeeklyStats = $settingReceiveWeeklyStats;

        return $this;
    }

    /**
     * Get settingReceiveWeeklyStats
     *
     * @return boolean
     */
    public function getSettingReceiveWeeklyStats()
    {
        return $this->settingReceiveWeeklyStats;
    }

    /**
     * Set settingServiceTax
     *
     * @param string $settingServiceTax
     *
     * @return ProfessionalUser
     */
    public function setSettingServiceTax($settingServiceTax)
    {
        $this->settingServiceTax = $settingServiceTax;

        return $this;
    }

    /**
     * Get settingServiceTax
     *
     * @return string
     */
    public function getSettingServiceTax()
    {
        return $this->settingServiceTax;
    }

    /**
     * Set settingProductTax
     *
     * @param string $settingProductTax
     *
     * @return ProfessionalUser
     */
    public function setSettingProductTax($settingProductTax)
    {
        $this->settingProductTax = $settingProductTax;

        return $this;
    }

    /**
     * Get settingProductTax
     *
     * @return string
     */
    public function getSettingProductTax()
    {
        return $this->settingProductTax;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return ProfessionalUser
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @return string
     */
    public function getFacebookPage()
    {
        return $this->facebookPage;
    }

    /**
     * @param string $facebookPage
     */
    public function setFacebookPage($facebookPage)
    {
        $this->facebookPage = $facebookPage;
    }

    /**
     * @return string
     */
    public function getTwitterAccount()
    {
        return $this->twitterAccount;
    }

    /**
     * @param string $twitterAccount
     */
    public function setTwitterAccount($twitterAccount)
    {
        $this->twitterAccount = $twitterAccount;
    }

    /**
     * @return string
     */
    public function getBlogPage()
    {
        return $this->blogPage;
    }

    /**
     * @param string $blogPage
     */
    public function setBlogPage($blogPage)
    {
        $this->blogPage = $blogPage;
    }

    /**
     * @return string
     */
    public function getFeaturedTo()
    {
        return $this->featuredTo;
    }

    /**
     * @param string $featuredTo
     */
    public function setFeaturedTo($featuredTo)
    {
        $this->featuredTo = $featuredTo;
    }

    /**
     * @return string
     */
    public function getFeaturedFrom()
    {
        return $this->featuredFrom;
    }

    /**
     * @param string $featuredFrom
     */
    public function setFeaturedFrom($featuredFrom)
    {
        $this->featuredFrom = $featuredFrom;
    }

    /**
     * @return Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @param Gallery $gallery
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;
    }

    /**
     * @return Salon
     */
    public function getSalon()
    {
        return $this->salon;
    }

    /**
     * @param Salon $salon
     */
    public function setSalon($salon)
    {
        $this->salon = $salon;
    }

    /**
     * @return ArrayCollection
     */
    public function getServiceGroups()
    {
        return $this->serviceGroups;
    }

    /**
     * @return ArrayCollection
     */
    public function getRecommendations()
    {
        return $this->recommendations;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return array
     */
    public function getInterests()
    {
        return $this->interests;
    }

    /**
     * @param array $interests
     */
    public function setInterests($interests)
    {
        $this->interests = $interests;
    }

    /**
     * @return ArrayCollection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param ArrayCollection $tasks
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * @return string
     */
    public function getPreferredPhoneOnProfile()
    {
        return $this->preferredPhoneOnProfile;
    }

    /**
     * @param string $preferredPhoneOnProfile
     */
    public function setPreferredPhoneOnProfile($preferredPhoneOnProfile)
    {
        $this->preferredPhoneOnProfile = $preferredPhoneOnProfile;
    }
}
