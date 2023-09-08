<?php

// src/AppBundle/Entity/Application.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Offre Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ApplicationRepository")
 * @ORM\Table(name="application")
 */
class Application
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="applications")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="applications")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $course;

    /**
     * @ORM\ManyToOne(targetEntity="School")
     * @ORM\JoinColumn(name="school_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $school;

    /**
     * @ORM\ManyToOne(targetEntity="TrainingType")
     * @ORM\JoinColumn(name="trainingType_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $trainingType;

    /**
     * @ORM\ManyToOne(targetEntity="DiplomaType")
     * @ORM\JoinColumn(name="diplomaType_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $diplomaType;

    /**
     * @ORM\OneToMany(targetEntity="ApplicationDiploma", mappedBy="application", cascade={"persist"})
     * @ORM\OrderBy({"ord" = "ASC"})
     */
    private $applicationDiplomas;


    /**
     * @ORM\Column(type="integer",name="status", length=45, nullable=true)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="Document", mappedBy="application")
     */
    private $documents;

    /**
     *
     * @ORM\Column(type="datetime",name="created_at", nullable = true)
     */
    private $createdAt;

    /**
     *
     * @ORM\Column(type="datetime",name="updated_at", nullable = true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean",name="mail_confirmation", nullable=true)
     */
    private $mailConfirmation;

    /**
     * @ORM\Column(type="boolean",name="payment_receipt_uploaded", nullable=true)
     */
    private $paymentReceiptUploaded;

    /**
     * @ORM\Column(type="boolean",name="documents_uploaded", nullable=true)
     */
    private $documentsUploaded;

    /**
     * @ORM\Column(type="boolean",name="mail_relance", nullable=true)
     */
    private $mailRelance;

    /**
     * Constructor
     */
    public function __construct() {
        $this->createdAt = new \DateTime("now");
        $this->applicationDiplomas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    function getId() {
        return $this->id;
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
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param mixed $course
     */
    public function setCourse($course)
    {
        $this->course = $course;
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
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getMailConfirmation()
    {
        return $this->mailConfirmation;
    }

    /**
     * @param mixed $mailConfirmation
     */
    public function setMailConfirmation($mailConfirmation)
    {
        $this->mailConfirmation = $mailConfirmation;
    }

    /**
     * @return mixed
     */
    public function getPaymentReceiptUploaded()
    {
        return $this->paymentReceiptUploaded;
    }

    /**
     * @param mixed $paymentReceiptUploaded
     */
    public function setPaymentReceiptUploaded($paymentReceiptUploaded)
    {
        $this->paymentReceiptUploaded = $paymentReceiptUploaded;
    }

    /**
     * @return mixed
     */
    public function getDocumentsUploaded()
    {
        return $this->documentsUploaded;
    }

    /**
     * @param mixed $documentsUploaded
     */
    public function setDocumentsUploaded($documentsUploaded)
    {
        $this->documentsUploaded = $documentsUploaded;
    }

    /**
     * @return mixed
     */
    public function getMailRelance()
    {
        return $this->mailRelance;
    }

    /**
     * @param mixed $mailRelance
     */
    public function setMailRelance($mailRelance)
    {
        $this->mailRelance = $mailRelance;
    }

    /**
     * Set school
     *
     * @param \AppBundle\Entity\School $school
     * @return Application
     */
    public function setSchool(\AppBundle\Entity\School $school)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return \AppBundle\Entity\School
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set trainingType
     *
     * @param \AppBundle\Entity\TrainingType $trainingType
     * @return Application
     */
    public function setTrainingType(\AppBundle\Entity\TrainingType $trainingType)
    {
        $this->trainingType = $trainingType;

        return $this;
    }

    /**
     * Get trainingType
     *
     * @return \AppBundle\Entity\TrainingType
     */
    public function getTrainingType()
    {
        return $this->trainingType;
    }

    /**
     * Set diplomaType
     *
     * @param \AppBundle\Entity\DiplomaType $diplomaType
     * @return Application
     */
    public function setDiplomaType(\AppBundle\Entity\DiplomaType $diplomaType)
    {
        $this->diplomaType = $diplomaType;

        return $this;
    }

    /**
     * Get diplomaType
     *
     * @return \AppBundle\Entity\DiplomaType
     */
    public function getDiplomaType()
    {
        return $this->diplomaType;
    }

    /**
     * Add applicationDiplomas
     *
     * @param \AppBundle\Entity\ApplicationDiploma $applicationDiplomas
     * @return Application
     */
    public function addApplicationDiploma(\AppBundle\Entity\ApplicationDiploma $applicationDiplomas)
    {
        $this->applicationDiplomas[] = $applicationDiplomas;

        return $this;
    }

    /**
     * Remove applicationDiplomas
     *
     * @param \AppBundle\Entity\ApplicationDiploma $applicationDiplomas
     */
    public function removeApplicationDiploma(\AppBundle\Entity\ApplicationDiploma $applicationDiplomas)
    {
        $this->applicationDiplomas->removeElement($applicationDiplomas);
    }

    /**
     * Get applicationDiplomas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApplicationDiplomas()
    {
        return $this->applicationDiplomas;
    }

    /**
     * Add documents
     *
     * @param \AppBundle\Entity\Document $documents
     * @return Application
     */
    public function addDocument(\AppBundle\Entity\Document $documents)
    {
        $this->documents[] = $documents;

        return $this;
    }

    /**
     * Remove documents
     *
     * @param \AppBundle\Entity\Document $documents
     */
    public function removeDocument(\AppBundle\Entity\Document $documents)
    {
        $this->documents->removeElement($documents);
    }
}
