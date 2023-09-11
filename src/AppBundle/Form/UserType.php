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
