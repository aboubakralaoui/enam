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
