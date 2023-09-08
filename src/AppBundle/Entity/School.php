<?php

// src/AppBundle/Entity/School.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Offre Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SchoolRepository")
 * @UniqueEntity(
 *     fields={"name"},
 *     message="This name is already associated to another school"
 * )
 * @ORM\Table(name="school")
 */
class School {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string",name="name", unique=true, length=250, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $name;

    /**
     * @ORM\Column(type="string",name="code", length=45, nullable=true)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $code;

    /**
     * @ORM\Column(type="string",name="address", length=45, nullable=true)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $address;

    /**
     * @ORM\Column(type="string",name="phoneNumber", length=45, nullable=true)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $phoneNumber;

    /**
     *
     * @ORM\Column(type="datetime",name="created_at", nullable = false)
     */
    private $createdAt;

    /**
     *
     * @ORM\Column(type="datetime",name="updated_at", nullable = true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="Diploma", mappedBy="school")
     */
    private $diplomas;

    /**
     * Constructor
     */
    public function __construct() {
        $this->createdAt = new \DateTime("now");
    }

    function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getDiplomas()
    {
        return $this->diplomas;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    public function __toString() {
        return $this->getName();
    }

}
