<?php

// src/AppBundle/Entity/Diploma.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Offre Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DiplomaRepository")
 * @ORM\Table(name="diploma")
 */
class Diploma
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="School", inversedBy="diplomas")
     * @ORM\JoinColumn(name="school_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $school;

    /**
     * @ORM\ManyToOne(targetEntity="SchoolField", inversedBy="diplomas")
     * @ORM\JoinColumn(name="school_field_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $schoolField;

    /**
     * @ORM\ManyToOne(targetEntity="DiplomaType", inversedBy="diplomas")
     * @ORM\JoinColumn(name="diploma_type_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $diplomaType;

    /**
     * @ORM\ManyToOne(targetEntity="TrainingType")
     * @ORM\JoinColumn(name="training_type_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $trainingType;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Course", mappedBy="diplomas")
     */

    private $courses;

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
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * @param mixed $school
     */
    public function setSchool($school)
    {
        $this->school = $school;
    }

    /**
     * @return mixed
     */
    public function getSchoolField()
    {
        return $this->schoolField;
    }

    /**
     * @param mixed $schoolField
     */
    public function setSchoolField($schoolField)
    {
        $this->schoolField = $schoolField;
    }

    /**
     * @return mixed
     */
    public function getDiplomaType()
    {
        return $this->diplomaType;
    }

    /**
     * @param mixed $diplomaType
     */
    public function setDiplomaType($diplomaType)
    {
        $this->diplomaType = $diplomaType;
    }

    /**
     * @return mixed
     */
    public function getTrainingType()
    {
        return $this->trainingType;
    }

    /**
     * @param mixed $trainingType
     */
    public function setTrainingType($trainingType)
    {
        $this->trainingType = $trainingType;
    }



    function __toString()
    {
        return $this->getSchool()->getName()." / ".$this->getDiplomaType()->getName()." / ".$this->getSchoolField()->getName()." / ".$this->getTrainingType()->getName();
    }



    /**
     * Add courses
     *
     * @param \AppBundle\Entity\Course $courses
     * @return Diploma
     */
    public function addCourse(\AppBundle\Entity\Course $courses)
    {
        $this->courses[] = $courses;

        return $this;
    }

    /**
     * Remove courses
     *
     * @param \AppBundle\Entity\Course $courses
     */
    public function removeCourse(\AppBundle\Entity\Course $courses)
    {
        $this->courses->removeElement($courses);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourses()
    {
        return $this->courses;
    }
}
