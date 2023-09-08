<?php
// src/AppBundle/Entity/Role.php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RoleRepository")
 * @UniqueEntity(
 *     fields={"libelle"},
 *     message="Ce libellé est déja associé à un autre role"
 * )
 * @ORM\Table(name="roles")
 */
class Role {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", name="libelle", unique=true, length=70, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $libelle;
    
    /**
     * @ORM\ManyToMany(targetEntity="Feature", inversedBy="role",fetch="EXTRA_LAZY")
     * @ORM\JoinTable(
     *     name="autorisations",
     *     joinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="fonctionnalite_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $features;
    
    
    /**
     * Populate the features field
     */
    public function __construct(){
        $this->features = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    function getId() {
        return $this->id;
    }
    
    /**
     * Return the libelle field.
     * @return string 
     */
    public function getLibelle(){
        return $this->libelle;
    }
    
    /**
     * Set libelle
     * @param string $libelle
     * @return Role
     */
    function setLibelle($libelle) {
        $this->libelle = $libelle;
    }
    
        /**
     * Add feature
     *
     * @param Feature $feature
     * @return Role
     */
    public function addFeature(Feature $feature)
    {
        $this->features[] = $feature;

        return $this;
    }

    /**
     * Remove feature
     *
     * @param \Courses\Bundle\UserBundle\Entity\Access $feature
     */
    public function removeFeature(Feature $feature)
    {
        $this->features->removeElement($feature);
    }

    /**
     * Get features
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFeatures()
    {
        return $this->features;
    }
    
    /**
     * Return the label field.
     * @return string 
     */
    public function __toString(){
        return (string) $this->libelle;
    }
}