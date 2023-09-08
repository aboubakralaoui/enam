<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Repository\NationalityRepository;

class UserAdminEditType extends AbstractType
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
            ->add('school',null,array('label' => 'Etablissement :'));
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