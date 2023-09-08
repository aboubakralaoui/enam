<?php
// src/AppBundle/Entity/Feature.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Role Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FeatureRepository")
 * @UniqueEntity(
 *     fields={"code"},
 *     message="Ce code est déja associé à une autre fonctionnalité"
 * )
 * @ORM\Table(name="fonctionnalites")
 */
class Feature {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string",name="code", unique=true, length=100, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $code;
    
    /**
     * @ORM\Column(type="text", name="description", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    protected $description;
    
    
    
    
    /**
     * Constructor
     */
    public function __construct() {
       
    }
    
    function getId() {
        return $this->id;
    }
    
    /**
     * Get code
     * @return string
     */
    function getCode() {
        return $this->code;
    }
    
    /**
     * Get description
     * @return string
     */
    function getDescription() {
        return $this->description;
    }

    /**
     * Set code
     * @param string $code
     * @return Feature
     */
    function setCode($code) {
        $this->code = $code;
    }

    /**
     * Set description
     * @param string $description
     * @return Feature
     */
    function setDescription($description) {
        $this->description = $description;
    }
      
    /**
     * @return name
     */
    public function __toString() {
        return $this->getDescription();
    }

}