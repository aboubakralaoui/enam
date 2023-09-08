<?php

// src/AppBundle/Entity/TrainingType.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Offre Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrainingTypeRepository")
 * @UniqueEntity(
 *     fields={"name"},
 *     message="This name is already associated to another Training type"
 * )
 * @ORM\Table(name="training_type")
 */
class TrainingType
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

    public function __toString() {
        return $this->getName();
    }

}
