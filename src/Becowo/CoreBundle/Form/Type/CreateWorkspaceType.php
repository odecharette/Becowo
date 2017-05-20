<?php

namespace Becowo\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Becowo\CoreBundle\Form\Type\TeamMemberType;
use Symfony\Component\Validator\Constraints\Valid;

class CreateWorkspaceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => false, 'attr' => array('placeholder' => 'Saisir un nom')))
            ->add('street', HiddenType::class)
            ->add('postCode', HiddenType::class)
            ->add('city', HiddenType::class)
            ->add('country', EntityType::class, array(
                'class' => 'BecowoCoreBundle:Country',
                'choice_label' => 'name',
                'label' => false,
                'attr' => array('class' => 'hidden')
            ))
            ->add('longitude', HiddenType::class)
            ->add('latitude', HiddenType::class)
            ->add('category', EntityType::class, array(
                'class' => 'BecowoCoreBundle:WorkspaceCategory',
                'choice_label' => 'name',
                'placeholder' => 'Choisir une catégorie',
            ))
            // ->add('description',   TextareaType::class)
            // ->add('descriptionBonus',   TextType::class)
            ->add('website', TextType::class, array('required' => false, 'attr' => array('placeholder' => 'http://www.monsite.com')))
            ->add('facebookLink', TextType::class, array('required' => false, 'attr' => array('placeholder' => 'https://www.facebook.com/monProfil')))
            ->add('twitterLink', TextType::class, array('required' => false, 'attr' => array('placeholder' => 'https://twitter.com/monProfil')))
            ->add('instagramLink', TextType::class, array('required' => false, 'attr' => array('placeholder' => 'https://www.instagram.com/monProfil')))
            ->add('firstBookingFree', CheckBoxType::class, array('label' => 'Première réservation gratuite'))
            ->add('isAlwaysOpen', CheckBoxType::class, array('label' => 'Ouvert 24/24j 7/7j'))
            ->add('amenitiesDesc', TextareaType::class, array('label' => 'Description de vos services'))
            ->add('workspaceHasAmenitiesList', CollectionType::class, array(
                'entry_type' => WorkspaceHasAmenitiesType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'constraints' => array(new Valid())))
            ->add('offer', EntityType::class, array(
                'class' => 'BecowoCoreBundle:Offer',
                'choice_label' => 'name',
                'placeholder' => 'Choisir une offre',
            ))
            ->add('workspaceHasOfficeList', CollectionType::class, array(
                'entry_type' => WorkspaceHasOfficeType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'constraints' => array(new Valid())))
            ->add('timetable', TimetableType::class, array('label' => false))
            ->add('teamMembers', CollectionType::class, array(
                'entry_type' => TeamMemberType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'constraints' => array(new Valid())))
            ->add('pictures', CollectionType::class, array(
                'entry_type' => PictureType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'constraints' => array(new Valid())))
            ->add('draft', SubmitType::class)
            ->add('send', SubmitType::class)
            ->add('draft2', SubmitType::class)
            ->add('send2', SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Becowo\CoreBundle\Entity\Workspace',
            'cascade_validation' => true,   // This causes the entity constraint validation to trigger in the child types shown in the form
        ));
    }
}
