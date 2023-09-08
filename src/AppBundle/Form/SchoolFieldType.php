<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SchoolFieldType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',null,array('label' => 'Libellé :'))
            ->add('dateAccreditation',"date",array('label' => "Date d'accréditation :",'widget' => 'single_text','format' => 'dd/MM/yyyy','attr' => array('class' => 'mask_date')))
            ->add('description',null,array('label' => 'Description :','attr' => array('class' => 'wysihtml5','rows' => 10)));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\SchoolField'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_schoolfield';
    }


}
