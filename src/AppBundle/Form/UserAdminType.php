<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Repository\NationalityRepository;

class UserAdminType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',null,array('label' => 'Email :'))
            ->add('firstName',null,array('label' => 'Prénom :'))
            ->add('lastName',null,array('label' => 'Nom :'))
            ->add('phoneNumber',null,array('label' => 'Numéro de téléphone :'))
            ->add('role', 'choice', array(
                'expanded' => false,
                'multiple' => false,
                'choices' => array(
                    'administrator' => "Administrateur",
                    'responsable' => "Responsable",
                )
            ))
            ->add('school',null,array('label' => 'Etablissement :'))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Passwords have to be equal.',
                'first_name'      => 'Password',
                'second_name'     => 'Confirmation',
            ));
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


}