<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Application\Entity\CityRepository")
 */
class City
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
     * @Gedmo\Slug(handlers={
     *      @Gedmo\SlugHandler(class="Gedmo\Sluggable\Handler\InversedRelativeSlugHandler", options={
     *          @Gedmo\SlugHandlerOption(name="relationClass", value="Application\Entity\Professional\Salon"),
     *          @Gedmo\SlugHandlerOption(name="mappedBy", value="city"),
     *          @Gedmo\SlugHandlerOption(name="inverseSlugField", value="slug")
     *      })
     * }, fields={"name"})
     * @ORM\Column(name="citySlug", type="string", length=255)
     */
    private $citySlug;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\County",
     *  inversedBy="cities",
     *  cascade={"persist"})
     */
    private $county;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isCapital", type="boolean")
     */
    private $isCapital;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isDistrict", type="boolean")
     */
    private $isDistrict;

    /**
     * @var string
     *
     * @ORM\Column(name="postCode", type="string", length=8)
     */
    private $postCode;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\Entity\ProfessionalUser",
     *  mappedBy="city")
     */
    private $professionals;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\Entity\Professional\Salon",
     *  mappedBy="city")
     */
    private $salons;

    public function __toString()
    {
        return $this->name;
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
     *
     * @return City
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
     * Set county
     *
     * @param integer $county
     *
     * @return City
     */
    public function setCounty($county)
    {
        $this->county = $county;

        return $this;
    }

    /**
     * Get county
     *
     * @return integer
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * Set isCapital
     *
     * @param boolean $isCapital
     *
     * @return City
     */
    public function setIsCapital($isCapital)
    {
        $this->isCapital = $isCapital;

        return $this;
    }

    /**
     * Get isCapital
     *
     * @return boolean
     */
    public function getIsCapital()
    {
        return $this->isCapital;
    }

    /**
     * Set isDistrict
     *
     * @param boolean $isDistrict
     *
     * @return City
     */
    public function setIsDistrict($isDistrict)
    {
        $this->isDistrict = $isDistrict;

        return $this;
    }

    /**
     * Get isDistrict
     *
     * @return boolean
     */
    public function getIsDistrict()
    {
        return $this->isDistrict;
    }

    /**
     * Set postCode
     *
     * @param string $postCode
     *
     * @return City
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
     * @return ArrayCollection
     */
    public function getProfessionals()
    {
        return $this->professionals;
    }

    /**
     * @return ArrayCollection
     */
    public function getSalons()
    {
        return $this->salons;
    }

    /**
     * @return string
     */
    public function getCitySlug()
    {
        return $this->citySlug;
    }
}
