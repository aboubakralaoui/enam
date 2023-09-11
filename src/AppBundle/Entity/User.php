<?php

// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"username"},
 *     message="Cet identifiant est déja associé à un autre utilisateur"
 * )
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Cet email est déja associé à un autre utilisateur"
 * )
 * @UniqueEntity(
 *     fields={"cin"},
 *     message="Ce code CIN est déja associé à un autre utilisateur"
 * )
 * @ORM\Table(name="users")
 *
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="username",
 *          column=@ORM\Column(
 *              type =  "string",
 *              name     = "username",
 *              nullable = true,
 *              unique   = false
 *          )
 *      ),
 *      @ORM\AttributeOverride(name="usernameCanonical",
 *          column=@ORM\Column(
 *              type = "string",
 *              name     = "username_canonical",
 *              nullable = true,
 *              unique   = false
 *          )
 *      ),
 *      *@ORM\AttributeOverride(name="password",
 *          column=@ORM\Column(
 *              type = "string",
 *              name     = "password",
 *              nullable = true,
 *              unique   = false
 *          )
 *      )
 * })
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string",name="first_name", length=45, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string",name="last_name", length=45, nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string",name="cin", unique=true, length=45, nullable=true)
     */
    private $cin;

    /**
     * @ORM\Column(type="string",name="cne", length=45, nullable=true)
     */
    private $cne;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $sexe;

    /**
    * @ORM\Column(name="situation_professionnelle", type="string", length=255, nullable=true)
    */
        private $situationProfessionnelle;


    /**
     * @ORM\Column(type="boolean",name="internat", length=45, nullable=true)
     */
    private $internat;

    /**
     * @ORM\Column(type="string",name="address", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string",name="phoneNumber", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string",name="place_birth", length=45, nullable=true)
     */
    private $placeBirth;

    /**
     *
     * @ORM\Column(type="datetime",name="birth_date", nullable = true)
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string",name="role", length=45, nullable=false)
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity="Training", mappedBy="user")
     * @ORM\OrderBy({"yearGraduation" = "ASC"})
     */
    private $trainings;

    /**
     * @ORM\OneToMany(targetEntity="Application", mappedBy="user")
     */
    private $applications;

//    /**
//     * @ORM\ManyToOne(targetEntity="Nationality")
//     * @ORM\OrderBy({"id" = "ASC"})
//     * @ORM\JoinColumn(name="nationality_id", referencedColumnName="id", nullable=true)
//     */
//    private $nationality;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationality;

    /**
     *
     * @ORM\ManyToMany(targetEntity="DiplomaType", inversedBy="users")
     * @ORM\OrderBy({"order" = "ASC"})
     * @ORM\JoinTable(
     *  name="user_diploma_type",
     *  joinColumns={
     *      @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="diploma_type_id", referencedColumnName="id")
     *  }
     * )
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $diplomaTypes;

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
     * @ORM\ManyToOne(targetEntity="School")
     * @ORM\OrderBy({"id" = "ASC"})
     * @ORM\JoinColumn(name="school_id", referencedColumnName="id", nullable=true)
     */
    private $school;

    /**
     * One Customer has Online Payment.
     * @ORM\OneToMany(targetEntity="OnlinePayment", mappedBy="candidate")
     */
    private $onlinePayments;


    public function __construct() {
        parent::__construct();
        $this->trainings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->diplomaTypes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->role= "student";
        $this->createdAt = new \DateTime("now");
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getRole() {
        return $this->role;
    }

    public function getSexe()
    {
        return $this->sexe;
    }

    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
        return $this;
    }

    public function getSituationProfessionnelle()
    {
        return $this->situationProfessionnelle;
    }

    public function setSituationProfessionnelle($situationProfessionnelle)
    {
        $this->situationProfessionnelle = $situationProfessionnelle;

        return $this;
    }


    function setRole($role) {
        $this->role = $role;
    }

    function getInternat() {
        return $this->internat;
    }

    function setInternat($internat) {
        $this->internat = $internat;
    }

    /**
     * @return mixed
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * @param mixed $cin
     */
    public function setCin($cin)
    {
        $this->cin = $cin;
    }

    /**
     * @return mixed
     */
    public function getFather()
    {
        return $this->father;
    }

    /**
     * @param mixed $father
     */
    public function setFather($father)
    {
        $this->father = $father;
    }

    /**
     * @return mixed
     */
    public function getMother()
    {
        return $this->mother;
    }

    /**
     * @param mixed $mother
     */
    public function setMother($mother)
    {
        $this->mother = $mother;
    }



    /**
     * @return mixed
     */
    public function getCne()
    {
        return $this->cne;
    }

    /**
     * @param mixed $cne
     */
    public function setCne($cne)
    {
        $this->cne = $cne;
    }

    /**
     * @return mixed
     */
    public function getTrainings()
    {
        return $this->trainings;
    }

    /**
     * @param mixed $trainings
     */
    public function setTrainings($trainings)
    {
        $this->trainings = $trainings;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param mixed $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getPlaceBirth()
    {
        return $this->placeBirth;
    }

    /**
     * @param mixed $placeBirth
     */
    public function setPlaceBirth($placeBirth)
    {
        $this->placeBirth = $placeBirth;
    }

    /**
     * @return mixed
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param mixed $nationality
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @param DiplomaType $diplomaType
     */
    public function addDiplomaType(DiplomaType $diplomaType)
    {
        if ($this->diplomaTypes->contains($diplomaType)) {
            return;
        }
        $this->diplomaTypes->add($diplomaType);
        $diplomaType->addUser($this);
    }

    public function containDyplomaType(DiplomaType $diplomaType)
    {
        if ($this->diplomaTypes->contains($diplomaType)) {
            return true;
        }
        return false;
    }

    /**
     * @param DiplomaType $diplomaType
     */
    public function removeDiplomaType(DiplomaType $diplomaType)
    {
        if (!$this->diplomaTypes->contains($diplomaType)) {
            return;
        }
        $this->diplomaTypes->removeElement($diplomaType);
        $diplomaType->removeUser($this);
    }

    /**
     * @return mixed
     */
    public function getDiplomaTypes()
    {
        return $this->diplomaTypes;
    }

    /**
     * @return mixed
     */
    public function getApplications()
    {
        return $this->applications;
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
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * @param mixed $school
     */
    public function setSchool($school)
    {
        $this->school = $school;
    }

    public function statusCandidat()
    {
        if(count($this->applications) == 0){
            return "Prospect";
        }
        $paymentReceiptUploaded = false;
        $documentsUploaded = false;
        foreach ($this->applications as $application){
            if($application->getPaymentReceiptUploaded()){
                $paymentReceiptUploaded = true;
            }
            if($application->getDocumentsUploaded()){
                $documentsUploaded = true;
            }
        }
        if($paymentReceiptUploaded){
            return "Affirmé";
        }
        if($documentsUploaded){
            return "Candidat";
        }
        return 'Prospect';
    }

    public function getTrainigToString()
    {
        $levelYear = "";
        if(count($this->trainings) > 0){
            $training = $this->trainings->last();
            $levelYear = $levelYear . $training->getYearGraduation() .' : '.$training->getLevel();
        }
        return $levelYear;
    }

    /**
     * @return mixed
     */
    public function getOnlinePayments()
    {
        return $this->onlinePayments;
    }
}
