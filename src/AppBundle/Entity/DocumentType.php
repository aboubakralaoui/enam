<?php
// src/AppBundle/Entity/DocumentType.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Role Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentTypeRepository")
 * @UniqueEntity(
 *     fields={"name"},
 *     message="This name is already associated to another document type"
 * )
 * @ORM\Table(name="document_type")
 */
class DocumentType {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string",name="name", unique=true, length=100, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $name;

    /**
     * @ORM\Column(type="string",name="code", length=100, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $code;

    /**
     * @ORM\Column(type="boolean",name="multiple", nullable=true)
     */
    private $multiple;

    /**
     * @ORM\Column(type="integer",name="order_row", nullable=true)
     */
    private $order;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Course", mappedBy="documentTypes")
     */

    private $courses;

    /**
     * Constructor
     */
    public function __construct() {
        $this->courses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     * @return int
     */
    function getId() {
        return $this->id;
    }
    
    /**
     * Get name
     * @return string
     */
    function getName() {
        return $this->name;
    }

    /**
     * Set name
     * @param string $name
     * @return DocumentType
     */
    function setName($name) {
        $this->name = $name;
    }

      
    /**
     * @return string
     */
    public function __toString() {
        return $this->getName();
    }

    /**
     * @param Course $course
     */
    public function addCourse(Course $course)
    {
        if ($this->courses->contains($course)) {
            return;
        }
        $this->courses->add($course);
        $course->addDocumentType($this);
    }

    /**
     * @param Course $course
     */
    public function removeCourse(Course $course)
    {
        if (!$this->courses->contains($course)) {
            return;
        }
        $this->courses->removeElement($course);
        $course->removeDocumentType($this);
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

    /**
     * @return mixed
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * @return mixed
     */
    public function getMultiple()
    {
        return $this->multiple;
    }

    /**
     * @param mixed $multiple
     */
    public function setMultiple($multiple)
    {
        $this->multiple = $multiple;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }
}