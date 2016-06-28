<?php

namespace Becowo\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PictureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url',   TextType::class)
            ->add('alt',   TextType::class)
            // ->add('isFavorite', CheckboxType::class, array(
            //     'label'    => 'Photo favorite ?'
            // ))
            // ->add('isLogo', CheckboxType::class, array(
            //     'label'    => 'Logo ?'
            // ))
         //   ->add('workspace')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Becowo\CoreBundle\Entity\Picture'
        ));
    }
}
