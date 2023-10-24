<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Repository\NationalityRepository;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('cin')
            ->add('nationality', 'entity', array(
                  'class' => 'AppBundle:Nationality',
                'query_builder' => function(NationalityRepository $er) {
                    return $er->createQueryBuilder('n')
                        ->orderBy('n.id', 'ASC');
                },
            ))
            ->add('firstName')
            ->add('lastName')
            ->add('birthDate', 'datetime', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
            ))
            ->add('placeBirth')
            ->add('phoneNumber')
            ->add('address')
            ->add('sexe', 'choice', array(
                'choices' => $this->getSexe(),
                'expanded' => false,
                'multiple' => false
            ))
            ->add('situationProfessionnelle', 'choice', array(
                'choices' => $this->getSituationProfessionnelles(),
                'expanded' => false,
                'multiple' => false
            ))
            ->add('typeBaccalaureat', 'choice', array(
                'choices' => $this->getTypeBaccalaureats(),
                'expanded' => false,
                'multiple' => false
            ))
            ->add('codeNational')
            ->add('moyenneBaccalaureat')
            ->add('mentionBaccalaureat', 'choice', array(
                'choices' => $this->getMentionBaccalaureats(),
                'expanded' => false,
                'multiple' => false
            ))
            ->add('anneeInscriptionSecondaire', 'choice', array(
                'choices' => $this->getAnnees(),
                'expanded' => false,
                'multiple' => false
            ))
            ->add('anneeObtentionDiplome', 'choice', array(
                'choices' => $this->getAnnees(),
                'expanded' => false,
                'multiple' => false
            ))
            ->add('typeDiplome', 'choice', array(
                'choices' => array("Bac + 5" => "Bac + 5" ,
                    "Licence" => "Licence"),
                'expanded' => false,
                'multiple' => false
            ))
            ->add('mentionDiplome', 'choice', array(
                'choices' => $this->getMentionBaccalaureats(),
                'expanded' => false,
                'multiple' => false
            ))
            ->add('intituleFiliere')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }

    public function getName()
    {
        return 'appbundle_user_type';
    }

    public function getSexe() {
        return array(
            "Homme" => "Homme" ,
            "Femme" => "Femme"
        );
    }

    public function getSituationProfessionnelles() {
        return array(
            "Étudiant" => "Étudiant" ,
            "Fonctionnaire" => "Fonctionnaire",
            "Salarié" => "Salarié",
            "Autre" => "Autre"
        );
    }

    public function getTypeBaccalaureats() {
        return array(
            "Sciences Agronomiques" => "Sciences Agronomiques" ,
            "Sciences Mathématiques" => "Sciences Mathématiques",
            "Sciences Physiques et Chimiques" => "Sciences Physiques et Chimiques",
            "Sciences de la Vie et de la Terre" => "Sciences de la Vie et de la Terre",
            "Sciences et Technologies Electriques" => "Sciences et Technologies Electriques",
            "Sciences et Technologies Mécaniques" => "Sciences et Technologies Mécaniques",
            "Autre" => "Autre"
        );
    }

    public function getMentionBaccalaureats() {
        return array(
            "Très Bien" => "Très Bien" ,
            "Bien" => "Bien",
            "Assez Bien" => "Assez Bien",
            "Passable" => "Passable"
        );
    }

    public function getAnnees() {
        $annees = array();

        for ($annee = 1980; $annee <2024; $annee++) {
            $annees[$annee] =  $annee;
        }

        return $annees;
    }
}
