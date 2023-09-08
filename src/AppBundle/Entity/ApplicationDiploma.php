<?php

// src/AppBundle/Entity/ApplicationDiploma.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Offre Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="application_diploma")
 */
class ApplicationDiploma
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Application", inversedBy="applicationDiplomas")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $application;

    /**
     * @ORM\ManyToOne(targetEntity="Diploma")
     * @ORM\JoinColumn(name="diploma_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $diploma;


    /**
     * @ORM\Column(type="integer",name="ord", length=45, nullable=true)
     */
    private $ord;


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
     * Set application
     *
     * @param \AppBundle\Entity\Application $application
     * @return ApplicationDiploma
     */
    public function setApplication(\AppBundle\Entity\Application $application)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application
     *
     * @return \AppBundle\Entity\Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Set diploma
     *
     * @param \AppBundle\Entity\Diploma $diploma
     * @return ApplicationDiploma
     */
    public function setDiploma(\AppBundle\Entity\Diploma $diploma)
    {
        $this->diploma = $diploma;

        return $this;
    }

    /**
     * Get diploma
     *
     * @return \AppBundle\Entity\Diploma
     */
    public function getDiploma()
    {
        return $this->diploma;
    }

    /**
     * Set ord
     *
     * @param integer $ord
     * @return ApplicationDiploma
     */
    public function setOrd($ord)
    {
        $this->ord = $ord;

        return $this;
    }

    /**
     * Get ord
     *
     * @return integer 
     */
    public function getOrd()
    {
        return $this->ord;
    }
}
