<?php

// src/AppBundle/Entity/SchoolField.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Offre Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SchoolFieldRepository")
 * @UniqueEntity(
 *     fields={"name"},
 *     message="This name is already associated to another school field"
 * )
 * @ORM\Table(name="school_field")
 */
class SchoolField
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string",name="name", unique=true, length=255, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $name;

    /**
     *
     * @ORM\Column(type="datetime",name="date_accreditation", nullable = false)
     */
    protected $dateAccreditation;

    /**
     * @ORM\Column(type="text", name="description", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="Diploma", mappedBy="schoolField")
     */
    private $diplomas;

    /**
     * Constructor
     */
    public function __construct() {
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
    public function getDateAccreditation()
    {
        return $this->dateAccreditation;
    }

    /**
     * @param mixed $dateAccreditation
     */
    public function setDateAccreditation($dateAccreditation)
    {
        $this->dateAccreditation = $dateAccreditation;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDiplomas()
    {
        return $this->diplomas;
    }

    public function __toString() {
        return $this->getName();
    }
}
