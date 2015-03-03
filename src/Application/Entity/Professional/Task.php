<?php

namespace Application\Entity\Professional;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Task
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
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_premium", type="boolean")
     */
    private $isPremium;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="read_more_link", type="string", length=255)
     */
    private $readMoreLink;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Application\Entity\ProfessionalUser", mappedBy="tasks")
     */
    private $professionals;


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
     * Set isPremium
     *
     * @param boolean $isPremium
     * @return Task
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
     * Set description
     *
     * @param string $description
     * @return Task
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
     * Set readMoreLink
     *
     * @param string $readMoreLink
     * @return Task
     */
    public function setReadMoreLink($readMoreLink)
    {
        $this->readMoreLink = $readMoreLink;

        return $this;
    }

    /**
     * Get readMoreLink
     *
     * @return string 
     */
    public function getReadMoreLink()
    {
        return $this->readMoreLink;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return ArrayCollection
     */
    public function getProfessionals()
    {
        return $this->professionals;
    }
}
