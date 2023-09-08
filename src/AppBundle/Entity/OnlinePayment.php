<?php

// src/AppBundle/Entity/OnlinePayment.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OnlinePaymentRepository")
 * @ORM\Table(name="online_payment")
 */
class OnlinePayment {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string",name="nom_cmr", length=255, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $nomCmr;

    /**
     * @ORM\Column(type="string",name="commande_id", length=255, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $commandeId;

    /**
     * @ORM\Column(type="string",name="num_trans", length=255, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $numTrans;

    /**
     * @ORM\Column(type="string",name="date_trans", length=255, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $dateTrans;

    /**
     * @ORM\Column(type="string",name="num_autorisation", length=255, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $numAutorisation;

    /**
     * @ORM\Column(type="string",name="num_carte", length=255, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $numCarte;

    /**
     * @ORM\Column(type="string",name="type_carte", length=255, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $typeCarte;

    /**
     * @ORM\Column(type="string",name="montant", length=255, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $candidate;


    public function __construct() {
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNomCmr()
    {
        return $this->nomCmr;
    }

    /**
     * @param mixed $nomCmr
     */
    public function setNomCmr($nomCmr)
    {
        $this->nomCmr = $nomCmr;
    }

    /**
     * @return mixed
     */
    public function getCommandeId()
    {
        return $this->commandeId;
    }

    /**
     * @param mixed $commandeId
     */
    public function setCommandeId($commandeId)
    {
        $this->commandeId = $commandeId;
    }

    /**
     * @return mixed
     */
    public function getNumTrans()
    {
        return $this->numTrans;
    }

    /**
     * @param mixed $numTrans
     */
    public function setNumTrans($numTrans)
    {
        $this->numTrans = $numTrans;
    }

    /**
     * @return mixed
     */
    public function getDateTrans()
    {
        return $this->dateTrans;
    }

    /**
     * @param mixed $dateTrans
     */
    public function setDateTrans($dateTrans)
    {
        $this->dateTrans = $dateTrans;
    }

    /**
     * @return mixed
     */
    public function getNumAutorisation()
    {
        return $this->numAutorisation;
    }

    /**
     * @param mixed $numAutorisation
     */
    public function setNumAutorisation($numAutorisation)
    {
        $this->numAutorisation = $numAutorisation;
    }

    /**
     * @return mixed
     */
    public function getNumCarte()
    {
        return $this->numCarte;
    }

    /**
     * @param mixed $numCarte
     */
    public function setNumCarte($numCarte)
    {
        $this->numCarte = $numCarte;
    }

    /**
     * @return mixed
     */
    public function getTypeCarte()
    {
        return $this->typeCarte;
    }

    /**
     * @param mixed $typeCarte
     */
    public function setTypeCarte($TypeCarte)
    {
        $this->typeCarte = $typeCarte;
    }

    /**
     * @return mixed
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * @param mixed $montant
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

    /**
     * @return mixed
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * @param mixed $user
     */
    public function setCandidate($candidate)
    {
        $this->candidate = $candidate;
    }

}
