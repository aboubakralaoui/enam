<?php

// src/AppBundle/Entity/Course.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Offre Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CourseRepository")
 * @ORM\Table(name="course")
 */
class Course {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string",name="name", length=255, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $name;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Diploma", inversedBy="courses")
     * @ORM\JoinTable(
     *  name="course_diploma",
     *  joinColumns={
     *      @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="diploma_id", referencedColumnName="id")
     *  }
     * )
     */
    private $diplomas;

    /**
     * @ORM\Column(type="text", name="conditions", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    protected $conditions;

    /**
     *
     * @ORM\ManyToMany(targetEntity="DocumentType", inversedBy="courses")
     * @ORM\OrderBy({"order" = "ASC"})
     * @ORM\JoinTable(
     *  name="course_document_type",
     *  joinColumns={
     *      @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="document_type_id", referencedColumnName="id")
     *  }
     * )
     */
    private $documentTypes;

    /**
     * @ORM\Column(type="integer",name="school_year", length=100, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $schoolYear;

    /**
     *
     * @ORM\Column(type="datetime",name="application_deadline", nullable = true)
     */
    protected $applicationDeadline;

    /**
     *
     * @ORM\Column(type="datetime",name="files_deadline", nullable = true)
     */
    protected $filesDeadline;

    /**
     *
     * @ORM\Column(type="datetime",name="payment_receipt_deadline", nullable = true)
     */
    protected $paymentReceiptDeadline;

    /**
     * Constructor
     */
    public function __construct() {
        $this->documentTypes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    /**
     * @return mixed
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
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @param mixed $conditions
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
    }

    /**
     * @param DocumentType $documentType
     */
    public function addDocumentType(DocumentType $documentType)
    {
        if ($this->documentTypes->contains($documentType)) {
            return;
        }
        $this->documentTypes->add($documentType);
        $documentType->addCourse($this);
    }

    /**
     * @param DocumentType $documentType
     */
    public function removeDocumentType(DocumentType $documentType)
    {
        if (!$this->documentTypes->contains($documentType)) {
            return;
        }
        $this->documentTypes->removeElement($documentType);
        $documentType->removeCourse($this);
    }

    /**
     * @return mixed
     */
    public function getDocumentTypes()
    {
        return $this->documentTypes;
    }

    function __toString()
    {
        return $this->getName();
    }



    /**
     * Add diplomas
     *
     * @param \AppBundle\Entity\Diploma $diplomas
     * @return Course
     */
    public function addDiploma(\AppBundle\Entity\Diploma $diplomas)
    {
        $this->diplomas[] = $diplomas;

        return $this;
    }

    /**
     * Remove diplomas
     *
     * @param \AppBundle\Entity\Diploma $diplomas
     */
    public function removeDiploma(\AppBundle\Entity\Diploma $diplomas)
    {
        $this->diplomas->removeElement($diplomas);
    }

    /**
     * Get diplomas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDiplomas()
    {
        return $this->diplomas;
    }

    /**
     * Set schoolYear
     *
     * @param integer $schoolYear
     * @return Course
     */
    public function setSchoolYear($schoolYear)
    {
        $this->schoolYear = $schoolYear;

        return $this;
    }

    /**
     * Get schoolYear
     *
     * @return integer 
     */
    public function getSchoolYear()
    {
        return $this->schoolYear;
    }

    /**
     * Set applicationDeadline
     *
     * @param \DateTime $applicationDeadline
     * @return Course
     */
    public function setApplicationDeadline($applicationDeadline)
    {
        $this->applicationDeadline = $applicationDeadline;

        return $this;
    }

    /**
     * Get applicationDeadline
     *
     * @return \DateTime 
     */
    public function getApplicationDeadline()
    {
        return $this->applicationDeadline;
    }

    /**
     * Set filesDeadline
     *
     * @param \DateTime $filesDeadline
     * @return Course
     */
    public function setFilesDeadline($filesDeadline)
    {
        $this->filesDeadline = $filesDeadline;

        return $this;
    }

    /**
     * Get filesDeadline
     *
     * @return \DateTime 
     */
    public function getFilesDeadline()
    {
        return $this->filesDeadline;
    }

    /**
     * Set paymentReceiptDeadline
     *
     * @param \DateTime $paymentReceiptDeadline
     * @return Course
     */
    public function setPaymentReceiptDeadline($paymentReceiptDeadline)
    {
        $this->paymentReceiptDeadline = $paymentReceiptDeadline;

        return $this;
    }

    /**
     * Get paymentReceiptDeadline
     *
     * @return \DateTime 
     */
    public function getPaymentReceiptDeadline()
    {
        return $this->paymentReceiptDeadline;
    }
}
