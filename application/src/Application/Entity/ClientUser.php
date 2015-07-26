<?php

namespace Application\Entity;

use Application\Model\User as UserInterface;
use UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;

/**
 * ClientUser
 *
 * @ORM\Table(name="user_client")
 * @ORM\Entity(repositoryClass="Application\Entity\ClientUserRepository")
 * @UniqueEntity(fields = "username",
 *  targetClass = "UserBundle\Entity\User",
 *  message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email",
 *  targetClass = "UserBundle\Entity\User",
 *  message="fos_user.email.already_used")
 */
class ClientUser extends User
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_birth", type="datetime", nullable=true)
     */
    private $dateOfBirth;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1)
     */
    protected $gender = UserInterface::GENDER_UNKNOWN;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\City",
     *  inversedBy="clients")
     */
    private $city;

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
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param \DateTime $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * Set city
     *
     * @param City $city
     *
     * @return User
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

}
