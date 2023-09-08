<?php

// src/AppBundle/Entity/DiplomaType.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Offre Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DiplomaTypeRepository")
 * @UniqueEntity(
 *     fields={"name"},
 *     message="This name is already associated to another diploma type"
 * )
 * @ORM\Table(name="diploma_type")
 */
class DiplomaType
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
     * @ORM\Column(type="text", name="description", nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    protected $description;

    /**
     * @ORM\Column(type="integer",name="order_row", nullable=true)
     */
    private $order;

    /**
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="diplomaTypes")
     */

    private $users;

    /**
     * @ORM\OneToMany(targetEntity="Diploma", mappedBy="diplomaType")
     */
    private $diplomas;

    /**
     * Constructor
     */
    public function __construct() {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function __toString() {
        return $this->getName();
    }

    /**
     * @param User $user
     */
    public function addUser(User $user)
    {
        if ($this->users->contains($user)) {
            return;
        }
        $this->users->add($user);
        $user->addDiplomaType($this);
    }

    /**
     * @param User $user
     */
    public function removeUser(User $user)
    {
        if (!$this->users->contains($user)) {
            return;
        }
        $this->users->removeElement($user);
        $user->removeDiplomaType($this);
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
