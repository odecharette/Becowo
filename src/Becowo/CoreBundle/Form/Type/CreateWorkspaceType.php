<?php

namespace Becowo\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Becowo\CoreBundle\Form\TeamMemberType;

class CreateWorkspaceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Nom *'))
            ->add('street', TextType::class, array('label' => 'Rue *'))
            ->add('postCode', NumberType::class, array('label' => 'Code postal *', 'scale' => 0))
            ->add('city', TextType::class, array('label' => 'Ville *'))
            ->add('country', EntityType::class, array(
                'class' => 'BecowoCoreBundle:Country',
                'choice_label' => 'name',
                'placeholder' => 'Choisir un pays',
            ))
            ->add('category', EntityType::class, array(
                'class' => 'BecowoCoreBundle:WorkspaceCategory',
                'choice_label' => 'name',
                'placeholder' => 'Choisir une catégorie',
            ))
            // ->add('description',   TextareaType::class)
            // ->add('descriptionBonus',   TextType::class)
            ->add('website', TextType::class, array('label' => 'Site internet', 'required' => false))
            ->add('facebookLink', TextType::class, array('label' => 'Page Facebook', 'required' => false))
            ->add('twitterLink', TextType::class, array('label' => 'Compte Twitter', 'required' => false))
            ->add('instagramLink', TextType::class, array('label' => 'Compte Instagram', 'required' => false))
            ->add('firstBookingFree')
            ->add('isAlwaysOpen')
            // ->add('longitude')
            // ->add('latitude')
            // ->add('teamMember', CollectionType::class, array(
            //     'entry_type' => TeamMemberType::class,
            //     'allow_add' => true,
            //     'allow_delete' => true))
            ->add('amenitiesDesc', TextType::class, array('label' => 'Description de vos services'))
            ->add('workspaceHasAmenitiesList', CollectionType::class, array(
                'entry_type' => WorkspaceHasAmenitiesType::class,
                'allow_add' => true,
                'allow_delete' => true))
            ->add('offer', EntityType::class, array(
                'class' => 'BecowoCoreBundle:Offer',
                'choice_label' => 'name',
                'placeholder' => 'Choisir une offre',
            ))
            ->add('workspaceHasOfficeList', CollectionType::class, array(
                'entry_type' => WorkspaceHasOfficeType::class,
                'allow_add' => true,
                'allow_delete' => true))
            ->add('timetable', TimetableType::class)
            ->add('Enregistrer', SubmitType::class)
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
