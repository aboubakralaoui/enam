<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder->add('schoolYear',null,array('label' => 'Année universitaire :'))
            ->add('name',null,array('label' => 'Libellé :'))
            ->add('diplomas',null,array('label' => 'Diplomes :','multiple' => true,'expanded' => true))
            ->add('conditions',null,array('label' => 'Conditions :','attr' => array('class' => 'wysihtml5','rows' => 10)))
            ->add('documentTypes','entity', array(
                'class' => 'AppBundle\Entity\DocumentType',
                'label' => 'Type des documents :',
                'expanded' => true,
                'multiple' => true,
                'required' => true,
            ))
            ->add('applicationDeadline',"date",array('required' => false,'label' => "Date limite de candidature :",'widget' => 'single_text','format' => 'dd/MM/yyyy','attr' => array('class' => 'mask_date')))
            ->add('paymentReceiptDeadline',"date",array('required' => false,'label' => "Date limite de paiement des frais de candidature :",'widget' => 'single_text','format' => 'dd/MM/yyyy','attr' => array('class' => 'mask_date')))
            ->add('filesDeadline',"date",array('required' => false,'label' => "Date du concours :",'widget' => 'single_text','format' => 'dd/MM/yyyy','attr' => array('class' => 'mask_date')));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Course'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_course';
    }


}
