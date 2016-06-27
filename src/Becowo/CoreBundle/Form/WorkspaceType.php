<?php

namespace Becowo\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class WorkspaceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',   TextType::class)
            ->add('description',   TextareaType::class)
            ->add('descriptionBonus',   TextType::class)
            // ->add('website')
            // ->add('isAlwaysOpen')
            // ->add('street')
            // ->add('postCode')
            // ->add('city')
            // ->add('longitude')
            // ->add('latitude')
            // ->add('firstBookingFree')
            // ->add('facebookLink')
            // ->add('twitterLink')
            // ->add('instagramLink')
            // ->add('isDeleted')
            // ->add('createdOn', 'datetime')
            // ->add('updatedOn', 'datetime')
            // ->add('isVisible')
            // ->add('category')
            // ->add('country')
            // ->add('poi')
            // ->add('teamMember')
            // ->add('amenities')
            // ->add('offer')
            // ->add('save',      SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Becowo\CoreBundle\Entity\Workspace'
        ));
    }
}
