<?php

namespace Becowo\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TimetableType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('openHour', TimeType::class, array(
                    'input'  => 'datetime',
                    'widget' => 'choice',
                    'error_bubbling' => true
                ))
                ->add('closeHour', TimeType::class, array(
                    'input'  => 'datetime',
                    'widget' => 'choice',
                    'error_bubbling' => true
                ))
                ->add('isOpenSaturday', CheckboxType::class, array(
                    'label'    => 'Ouvert le samedi',
                    'required' => false,
                    'error_bubbling' => true
                ))
                ->add('isOpenSunday', CheckboxType::class, array(
                    'label'    => 'Ouvert de dimanche',
                    'required' => false,
                    'error_bubbling' => true
                ))
                ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Becowo\CoreBundle\Entity\Timetable'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'becowo_corebundle_timetable';
    }


}
