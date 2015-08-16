<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Entity\Professional;

use Application\Model\Reminder;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 *
 * Represents a group of booked services in a row.
 * Empty time slot is not allowed between the services in a booking except for the lunchtime.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Application\Entity\Professional\BookingRepository")
 *
 * @package Application\Entity
 * @author Hargitai Dávid <div@diatigrah.hu>
 */
class Booking
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Reminder
     *
     * @ORM\Column(name="reminder_preference", type="object")
     */
    private $reminderPreference;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\ClientUser",
     *  inversedBy="bookings",
     *  cascade={"persist"})
     */
    private $client;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\ProfessionalUser",
     *  inversedBy="bookings",
     *  cascade={"persist"})
     */
    private $professional;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var array
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_recurring", type="boolean")
     */
    private $isRecurring;

    /**
     * @var integer
     *
     * @ORM\Column(name="recurring_frequency_in_weeks", type="integer", nullable=true)
     */
    private $recurringFrequencyInWeeks;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_at", type="datetime")
     */
    private $startAt;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\Entity\Professional\BookedService",
     *  mappedBy="booking",
     *  cascade={"remove"})
     */
    private $services;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_no_reminder", type="boolean")
     */
    private $isNoReminder;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_late_arrival", type="boolean")
     */
    private $isLateArrival;

    public function __construct()
    {
        $this->services = new ArrayCollection();
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
     * Set reminderPreference
     *
     * @param integer $reminderPreference
     *
     * @return Booking
     */
    public function setReminderPreference($reminderPreference)
    {
        $this->reminderPreference = $reminderPreference;

        return $this;
    }

    /**
     * Get reminderPreference
     *
     * @return integer
     */
    public function getReminderPreference()
    {
        return $this->reminderPreference;
    }

    /**
     * Set client
     *
     * @param \stdClass $client
     *
     * @return Booking
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \stdClass
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Booking
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isRecurring
     *
     * @param boolean $isRecurring
     *
     * @return Booking
     */
    public function setIsRecurring($isRecurring)
    {
        $this->isRecurring = $isRecurring;

        return $this;
    }

    /**
     * Get isRecurring
     *
     * @return boolean
     */
    public function getIsRecurring()
    {
        return $this->isRecurring;
    }

    /**
     * Set recurringFrequencyInWeeks
     *
     * @param integer $recurringFrequencyInWeeks
     *
     * @return Booking
     */
    public function setRecurringFrequencyInWeeks($recurringFrequencyInWeeks)
    {
        $this->recurringFrequencyInWeeks = $recurringFrequencyInWeeks;

        return $this;
    }

    /**
     * Get recurringFrequencyInWeeks
     *
     * @return integer
     */
    public function getRecurringFrequencyInWeeks()
    {
        return $this->recurringFrequencyInWeeks;
    }

    /**
     * Set startAt
     *
     * @param \DateTime $startAt
     *
     * @return Booking
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get startAt
     *
     * @return \DateTime
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set services
     *
     * @param array $services
     *
     * @return Booking
     */
    public function setServices($services)
    {
        $this->services = $services;

        return $this;
    }

    /**
     * Get services
     *
     * @return array
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Booking
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set isNoReminder
     *
     * @param boolean $isNoReminder
     *
     * @return Booking
     */
    public function setIsNoReminder($isNoReminder)
    {
        $this->isNoReminder = $isNoReminder;

        return $this;
    }

    /**
     * Get isNoReminder
     *
     * @return boolean
     */
    public function getIsNoReminder()
    {
        return $this->isNoReminder;
    }

    /**
     * Set isLateArrival
     *
     * @param boolean $isLateArrival
     *
     * @return Booking
     */
    public function setIsLateArrival($isLateArrival)
    {
        $this->isLateArrival = $isLateArrival;

        return $this;
    }

    /**
     * Get isLateArrival
     *
     * @return boolean
     */
    public function getIsLateArrival()
    {
        return $this->isLateArrival;
    }

    /**
     * @return int
     */
    public function getProfessional()
    {
        return $this->professional;
    }

    /**
     * @param int $professional
     */
    public function setProfessional($professional)
    {
        $this->professional = $professional;
    }

    /**
     * @return array
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param array $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
}

