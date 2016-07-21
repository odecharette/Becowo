<?php

namespace Becowo\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Becowo\CoreBundle\Form\TeamMemberType;

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
            ->add('teamMember', CollectionType::class, array(
                'entry_type' => TeamMemberType::class,
                'allow_add' => true,
                'allow_delete' => true))
            ->add('amenities', EntityType::class, array(
                'class' => 'BecowoCoreBundle:Amenities',
                'multiple' => true,
                'expanded' => true))
            // ->add('offer')
            // ->add('save',      SubmitType::class)
           // ->add('workspaceHasOffice', WorkspaceHasOfficeType::class)
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
