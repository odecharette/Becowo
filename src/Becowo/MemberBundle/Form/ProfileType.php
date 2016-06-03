<?php
namespace Becowo\MemberBundle\Form;
// Surcharge C:\wamp64\www\Becowo\vendor\friendsofsymfony\user-bundle\Form\Type\ProfileFormType.php

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Becowo\CoreBundle\Form\ProfilePictureType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder->add('firstname', TextType::class, array('required' => false));
    	$builder->add('name', TextType::class, array('required' => false));
    	$builder->add('sex', ChoiceType::class, array(
    		'choices' => array(
    			'Male' => false,
    			'Female' => true),
    		'expanded'=> true,
    		'multiple' => false,
    		'required' => false));
    	$builder->add('birthDate', DateType::class, array('required' => false));
    	$builder->add('phone', TextType::class, array('required' => false));
    	$builder->add('street', TextType::class, array('required' => false));
    	$builder->add('postcode', TextType::class, array('required' => false));
    	$builder->add('city', TextType::class, array('required' => false));
    	$builder->add('country', EntityType::class, array(
				    'class'        => 'BecowoCoreBundle:Country',
				    'choice_label' => 'name',
				    'multiple'     => false,
				    'expanded'	   => false));

        $builder->add('job', TextType::class, array('required' => false));
    	$builder->add('society', TextType::class, array('required' => false));
    	$builder->add('website', TextType::class, array('required' => false));
    	$builder->add('description', TextareaType::class, array('required' => false));
    	$builder->add('facebookLink', UrlType::class, array('required' => false));
    	$builder->add('twitterLink', UrlType::class, array('required' => false));
    	$builder->add('instagramLink', UrlType::class, array('required' => false));
    	$builder->add('linkedinLink', UrlType::class, array('required' => false));
    	$builder->add('profilePicture', ProfilePictureType::class);

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

    // For Symfony 2.x
    // public function getName()
    // {
    //     return $this->getBlockPrefix();
    // }
}