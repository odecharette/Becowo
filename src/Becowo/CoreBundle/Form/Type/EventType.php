<?php

namespace Becowo\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Titre'))
            ->add('description', TextareaType::class)
            ->add('category', EntityType::class, array(
                'class' => 'BecowoCoreBundle:EventCategory',
                'choice_label' => 'name',
                'label' => 'Catégorie'))
            ->add('startDate', DateTimeType::class, array('label' => 'Date de début', 'years' => range(date('Y'), date('Y')+2)))
            ->add('endDate', DateTimeType::class, array('label' => 'Date de fin', 'years' => range(date('Y'), date('Y')+2)))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Becowo\CoreBundle\Entity\Event'
        ));
    }
}
