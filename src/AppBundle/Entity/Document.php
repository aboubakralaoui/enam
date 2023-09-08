<?php
// src/AppBundle/Entity/Document.php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentRepository")
 * @ORM\Table(name="document")
 */
class Document {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string",name="filename", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $fileName;

    /**
     * @ORM\Column(type="string",name="extension", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $extension;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="DocumentType")
     * @ORM\JoinColumn(name="document_type_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $documentType;

    /**
     * @ORM\ManyToOne(targetEntity="Application", inversedBy="documents")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $application;

    /**
     * @ORM\Column(type="integer",name="status", length=45, nullable=true)
     */
    private $status;
    
    
    /**
     * Populate the features field
     */
    public function __construct(){
    }
    
    function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param mixed $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param mixed $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
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
    public function getDocumentType()
    {
        return $this->documentType;
    }

    /**
     * @param mixed $documentType
     */
    public function setDocumentType($documentType)
    {
        $this->documentType = $documentType;
    }

    /**
     * @return mixed
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param mixed $application
     */
    public function setApplication($application)
    {
        $this->application = $application;
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
     * Return the label field.
     * @return string 
     */
    public function __toString(){
        return (string) $this->fileName;
    }
}