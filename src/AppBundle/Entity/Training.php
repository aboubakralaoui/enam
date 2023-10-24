<?php
// src/AppBundle/Entity/Feature.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Role Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrainingRepository")
 * @ORM\Table(name="training")
 */
class Training {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer",name="year_graduation", length=100, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $yearGraduation;

    /**
     * @ORM\Column(type="string",name="specialty", length=255, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $specialty;

    /**
     * @ORM\Column(type="string", name="establishment", length=255, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    protected $establishment;

    /**
     * @ORM\Column(type="string", name="level", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    protected $level;

    /**
     * @ORM\Column(type="string", name="moyenne", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    protected $moyenne;

    /**
     * @ORM\Column(type="string", name="city", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    protected $city;

    /**
     * @ORM\Column(type="string", name="status", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    protected $status;

    /**
     * @ORM\Column(type="string", name="note_s1", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    protected $noteS1;

    /**
     * @ORM\Column(type="string", name="note_s2", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    protected $noteS2;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="trainings")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct() {

    }

    function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getYearGraduation()
    {
        return $this->yearGraduation;
    }

    /**
     * @param mixed $yearGraduation
     */
    public function setYearGraduation($yearGraduation)
    {
        $this->yearGraduation = $yearGraduation;
    }

    /**
     * @return mixed
     */
    public function getSpecialty()
    {
        return $this->specialty;
    }

    /**
     * @param mixed $specialty
     */
    public function setSpecialty($specialty)
    {
        $this->specialty = $specialty;
    }

    /**
     * @return mixed
     */
    public function getEstablishment()
    {
        return $this->establishment;
    }

    /**
     * @param mixed $establishment
     */
    public function setEstablishment($establishment)
    {
        $this->establishment = $establishment;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getMoyenne()
    {
        return $this->moyenne;
    }

    /**
     * @param mixed $moyenne
     */
    public function setMoyenne($moyenne)
    {
        $this->moyenne = $moyenne;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->moyenne;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getNoteS1()
    {
        return $this->noteS1;
    }

    /**
     * @param mixed $noteS1
     */
    public function setNoteS1($noteS1)
    {
        $this->noteS1 = $noteS1;
    }

    /**
     * @return mixed
     */
    public function getNoteS2()
    {
        return $this->noteS2;
    }

    /**
     * @param mixed $noteS2
     */
    public function setNoteS2($noteS2)
    {
        $this->noteS2 = $noteS2;
    }

    function __toString()
    {
        return $this->getSpecialty();
    }

}
