<?php

namespace Becowo\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class WorkspaceHasOfficeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('office', EntityType::class, array(
                'class' => 'BecowoCoreBundle:Office',
                'choice_label' => 'name',
                'label' => 'Bureau'))
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('file', FileType::class, array('multiple' => false, 'label' => 'Photo du bureau'))
            ->add('desk_qty', NumberType::class, array('label' => 'Capacité', 'scale' => 0))
            ->add('price', PriceInCreateWSType::class, array('label' => false))
            ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Becowo\CoreBundle\Entity\WorkspaceHasOffice'
        ));
    }
}
