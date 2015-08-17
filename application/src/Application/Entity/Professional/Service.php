<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Entity\Professional;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gedmo\Sortable\Entity\Repository\SortableRepository")
 *
 * @package Application\Entity
 */
class Service
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="dateinterval")
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal")
     */
    private $price;

    /**
     * @var boolean
     *
     * @ORM\Column(name="price_can_be_more", type="boolean", nullable=true)
     */
    private $priceCanBeMore = false;

    /**
     * @var string
     *
     * @ORM\Column(name="abbrevation", type="string", length=255, nullable=true)
     */
    private $abbrevation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="displayable_on_profile", type="boolean", nullable=true)
     */
    private $displayableOnProfile = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="online_booking_disabled", type="boolean", nullable=true)
     */
    private $onlineBookingDisabled = false;

    /**
     * @var ServiceGroup
     *
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Application\Entity\Professional\ServiceGroup", inversedBy="services")
     */
    private $group;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

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
     * Set name
     *
     * @param string $name
     * @return Service
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
     * Set length
     *
     * @param integer $duration
     * @return Service
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get length
     *
     * @return integer 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Service
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set priceCanBeMore
     *
     * @param boolean $priceCanBeMore
     * @return Service
     */
    public function setPriceCanBeMore($priceCanBeMore)
    {
        $this->priceCanBeMore = $priceCanBeMore;

        return $this;
    }

    /**
     * Get priceCanBeMore
     *
     * @return boolean 
     */
    public function getPriceCanBeMore()
    {
        return $this->priceCanBeMore;
    }

    /**
     * Set abbrevation
     *
     * @param string $abbrevation
     * @return Service
     */
    public function setAbbrevation($abbrevation)
    {
        $this->abbrevation = $abbrevation;

        return $this;
    }

    /**
     * Get abbrevation
     *
     * @return string 
     */
    public function getAbbrevation()
    {
        return $this->abbrevation;
    }

    /**
     * Set displayableOnProfile
     *
     * @param boolean $displayableOnProfile
     * @return Service
     */
    public function setDisplayableOnProfile($displayableOnProfile)
    {
        $this->displayableOnProfile = $displayableOnProfile;

        return $this;
    }

    /**
     * Get displayableOnProfile
     *
     * @return boolean 
     */
    public function getDisplayableOnProfile()
    {
        return $this->displayableOnProfile;
    }

    /**
     * Set onlineBookingDisabled
     *
     * @param boolean $onlineBookingDisabled
     * @return Service
     */
    public function setOnlineBookingDisabled($onlineBookingDisabled)
    {
        $this->onlineBookingDisabled = $onlineBookingDisabled;

        return $this;
    }

    /**
     * Get onlineBookingDisabled
     *
     * @return boolean 
     */
    public function getOnlineBookingDisabled()
    {
        return $this->onlineBookingDisabled;
    }

    /**
     * @return ServiceGroup
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param ServiceGroup $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param integer $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
}
