<?php
namespace Becowo\MemberBundle\Form\Type;
// Surcharge C:\wamp64\www\Becowo\vendor\friendsofsymfony\user-bundle\Form\Type\ProfileFormType.php

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Becowo\CoreBundle\Form\Type\ProfilePictureType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder
            ->add('firstname', TextType::class, array('required' => false))
    	    ->add('name', TextType::class, array('required' => false))
    	    ->add('sex', ChoiceType::class, array(
        		'choices' => array(
        			'Male' => false,
        			'Female' => true),
        		'expanded'=> true,
        		'multiple' => false,
        		'required' => false))
    	    ->add('birthDate', BirthdayType::class, array('required' => false))
            ->add('email', EmailType::class, array('required' => true))
    	    ->add('phone', TextType::class, array('required' => false))
    	    ->add('street', TextType::class, array('required' => false))
    	    ->add('postcode', TextType::class, array('required' => false))
    	    ->add('city', TextType::class, array('required' => false))
    	    ->add('country', EntityType::class, array(
			    'class'        => 'BecowoCoreBundle:Country',
			    'choice_label' => 'name',
			    'multiple'     => false,
			    'expanded'	   => false))

            ->add('job', TextType::class, array('required' => false))
    	    ->add('society', TextType::class, array('required' => false))
    	    ->add('website', TextType::class, array('required' => false))
    	    ->add('description', TextareaType::class, array('required' => false))
    	    ->add('facebookLink', UrlType::class, array('required' => false))
    	    ->add('twitterLink', UrlType::class, array('required' => false))
    	    ->add('instagramLink', UrlType::class, array('required' => false))
    	    ->add('linkedinLink', UrlType::class, array('required' => false))
    	    ->add('profilePicture', ProfilePictureType::class)
            ;

    	$builder->remove('current_password');
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';

    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }
}
