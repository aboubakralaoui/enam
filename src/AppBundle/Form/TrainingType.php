<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingType extends AbstractType
{
    const MANDATORY_LEVELS = array(
        "1ère année post bac" => "1ère année post bac" ,
        "2ème année post bac" => "2ème année post bac" ,
        "3ème année post bac" => "3ème année post bac",
    );
    const OPTIONAL_LEVELS = array(
        "4ème année post bac" => "4ème année post bac",
        "5ème année post bac" => "5ème année post bac",
    );
    private $years;
    private $levels;
    private $lastTraining;
    private $selectedYear;
    private $newLevelsArray;
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->years = $options['years'];
        $this->levels = $options['levels'];
        $this->lastTraining = $options['lastTraining'];
        $builder->add('level', 'choice', array(
            'choices' => $this->getLevels(),
            'expanded' => false,
            'multiple' => false
        ))
            ->add('yearGraduation', 'choice', array(
                'expanded' => false,
                'multiple' => false,
                'choices' => $this->getYears(),
                'data' => $this->selectedYear
            ))
            ->add('specialty')
            ->add('city')
            ->add('establishment')
            ->add('level', 'choice', array(
                'choices' => $this->getLevels(),
                'expanded' => false,
                'multiple' => false
            ))
            ->add('moyenne')
            ->add('noteS1')
            ->add('noteS2')
            ->add('status', 'choice', array(
                'choices' => array(
                    '' => "",
                    'Validée en session ordinaire' => "Validée en session ordinaire",
                    'Validée après rattrapage' => "Validée après rattrapage"
                )
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Training',
            'years' => null,
            'levels' => null,
            'lastTraining' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_training';
    }

    public function getYears(){
        $years = array();
        for( $i=1980; $i<= date("Y") ; $i++ )
        {
            if(!in_array($i,$this->years)){
                $years[$i] = $i . "/" . ($i + 1);
            }
        }
        for( $i= $this->selectedYear ; $i > 1980 ; $i-- )
        {
            if(!in_array($i,$this->years)){
                $this->selectedYear = $i;
                break;
            }
        }
        return $years;
    }

    public function getLevels(){
        $plusYear = $this->lastTraining == null ? 0 :(date("Y") - 1) - $this->lastTraining->getYearGraduation();
        $lastLevel = $this->lastTraining == null ? "" : $this->lastTraining->getLevel();
        $levelsArray = array_merge(self::MANDATORY_LEVELS,self::OPTIONAL_LEVELS);
        $this->selectedYear = date("Y") - 1;
        if($plusYear > 1) {
            $this->selectedYear = $this->lastTraining->getYearGraduation() == date("Y") - 1 ? date("Y") - 1 : $this->lastTraining->getYearGraduation() + 1;
        }


        $keys = array_keys($levelsArray);
        $last_key = end($keys);
        if( $this->lastTraining != null && $last_key == $this->lastTraining->getLevel()){
            $this->selectedYear = $this->lastTraining->getYearGraduation() - 1 ;
        }

        //$this->newLevelsArray =array();

        if (count($this->levels) == 0 ) {
            return $levelsArray;
        }

        foreach ($this->levels as &$value)
        {
            unset($levelsArray[$value]);
            $this->newLevelsArray = $levelsArray;
        }

        return $this->newLevelsArray;
    }


}
