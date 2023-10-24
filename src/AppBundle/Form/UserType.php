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
            ->add('cne')
//            ->add('nationality')
//            ->add('nationality', 'entity', array(
//                  'class' => 'AppBundle:Nationality',
//                'query_builder' => function(NationalityRepository $er) {
//                    return $er->createQueryBuilder('n')
//                        ->orderBy('n.id', 'ASC');
//                },
//            ))
            ->add('firstName')
            ->add('lastName')
            ->add('birthDate', 'datetime', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
            ))
//            ->add('father',null, array(
  //               "required" => true
    //        ))
      //      ->add('mother',null, array(
        //         "required" => true
          ////  ))
            ->add('placeBirth')
            ->add('phoneNumber')
            ->add('sexe', 'choice', array(
                'choices' => $this->getSexe(),
                'multiple' => false,
                'required' => true,
            ))
            ->add('nationality', 'choice', array(
                'choices' => $this->getNationalities(),
                'placeholder' => 'Sélectionnez une nationalité',
                'required' => true,
            ))
            ->add('situationProfessionnelle', 'choice', array(
                'choices' => [
                    'Étudiant' => 'Étudiant',
                    'Salarié' => 'Salarié',
                    'Fonctionnaire' => 'Fonctionnaire',
                    'Autre' => 'Autre',
                ],
                'placeholder' => 'Choisissez votre situation professionnelle',
                'required' => true,
                'label' => 'Situation Professionnelle',
            ))
            ->add('baccalaureatType', 'choice', array(
                'choices' => [
                    'Sciences Agronomiques' => 'Sciences Agronomiques',
                    'Sciences Mathématiques' => 'Sciences Mathématiques',
                    'Sciences Physiques et Chimiques' => 'Sciences Physiques et Chimiques',
                    'Sciences de la Vie et de la Terre' => 'Sciences de la Vie et de la Terre',
                    'Sciences et Technologies Electriques' => 'Sciences et Technologies Electriques',
                    'Sciences et Technologies Mécaniques' => 'Sciences et Technologies Mécaniques',
                    'Autre' => 'Autre',
                ],
                'placeholder' => 'Choisissez le type de baccalauréat',
                'required' => true,
                'label' => 'Baccalauréat',
            ))
            ->add('baccalaureatAverage')
            ->add('address');
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

    public function getSexe()
    {
        return [
            'Masculin' => 'masculin',
            'Féminin' => 'féminin',
        ];
    }

    private function getNationalities()
    {
        // Vous pouvez charger la liste complète des nationalités ici
        // Par exemple, si vous avez une liste prédéfinie :
        return [
            'Marocaine' => 'Marocaine',
            'Française' => 'Française',
            'Congolaise' => 'Congolaise',
            'Camrounaise' => 'Camrounaise',
            'Espagnole' => 'Espagnole',
            'Italienne' => 'Italienne',
            'Brésilienne' => 'Brésilienne',
            'Portugaise' => 'Portugaise',
            'Tunisienne' => 'Tunisienne',
            'Sénégalaise' => 'Sénégalaise',
            // Ajoutez ici les options pour chaque nationalité que vous souhaitez inclure
        ];
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


}
