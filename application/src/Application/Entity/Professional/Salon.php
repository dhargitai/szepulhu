<?php

namespace Application\Entity\Professional;

use Application\Entity\City;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Salon
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Application\Entity\Professional\SalonRepository")
 */
class Salon
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(handlers={
     *      @Gedmo\SlugHandler(class="Application\DoctrineExtension\Sluggable\Handler\PostfixerRelativeSlugHandler",
     *          options={
     *              @Gedmo\SlugHandlerOption(name="relationField", value="city"),
     *              @Gedmo\SlugHandlerOption(name="relationSlugField", value="slug"),
     *              @Gedmo\SlugHandlerOption(name="separator", value="-")
     *          }
     *      )
     * }, separator="-", updatable=true, fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true, nullable=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="map_url", type="string", length=500, nullable=true)
     */
    private $mapUrl;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\City",
     *  inversedBy="salons")
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="address_additional", type="string", length=255, nullable=true)
     */
    private $addressAdditional;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var Media
     *
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     */
    private $picture;

    /**
     * @var Media
     *
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     */
    private $map;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\Entity\ProfessionalUser", mappedBy="salon")
     */
    private $professionals;

    public function __construct()
    {
        $this->professionals = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Salon
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
     * Set slug
     *
     * @param string $slug
     * @return Salon
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set mapUrl
     *
     * @param string $mapUrl
     * @return Salon
     */
    public function setMapUrl($mapUrl)
    {
        $this->mapUrl = $mapUrl;

        return $this;
    }

    /**
     * Get mapUrl
     *
     * @return string
     */
    public function getMapUrl()
    {
        return $this->mapUrl;
    }

    /**
     * Get postCode
     *
     * @return string
     */
    public function getPostCode()
    {
        return $this->city->getPostCode();
    }

    /**
     * Set city
     *
     * @param City $city
     * @return Salon
     */
    public function setCity(City $city)
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
     * Set address
     *
     * @param string $address
     *
     * @return Salon
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
     * @return Salon
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
     * Set phone
     *
     * @param string $phone
     * @return Salon
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
     * @return ArrayCollection
     */
    public function getProfessionals()
    {
        return $this->professionals;
    }

    /**
     * @return Media
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param Media $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return Media
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * @param Media $map
     */
    public function setMap($map)
    {
        $this->map = $map;
    }
}
