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
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder->add('firstname', TextType::class);
    	$builder->add('name', TextType::class);
    	$builder->add('sex', ChoiceType::class, array(
    		'choices' => array(
    			'Homme' => false,
    			'Femme' => true),
    		'expanded'=> true,
    		'multiple' => false));
    	$builder->add('birthDate', DateType::class);
    	$builder->add('phone', TextType::class);
    	$builder->add('street', TextType::class);
    	$builder->add('postcode', TextType::class);
    	$builder->add('city', TextType::class);
    	$builder->add('country', EntityType::class, array(
				    'class'        => 'BecowoCoreBundle:Country',
				    'choice_label' => 'name',
				    'multiple'     => false,
				    'expanded'	   => false));

        $builder->add('job', TextType::class);
    	$builder->add('society', TextType::class);
    	$builder->add('website', TextType::class);
    	$builder->add('description', TextareaType::class);
    	$builder->add('facebookLink', UrlType::class);
    	$builder->add('twitterLink', UrlType::class);
    	$builder->add('instagramLink', UrlType::class);
    	$builder->add('linkedinLink', UrlType::class);
    	// TO DO
    	//$builder->add('profilePicture');

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