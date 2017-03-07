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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Becowo\CoreBundle\Form\DataTransformer\StringToJobTransformer;
use Doctrine\Common\Persistence\ObjectManager;

class ProfileType extends AbstractType
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
// ici on desactive les required pour le mettre au format annotation dans l'entité member
// Ainsi ce n'est pas le navigateur qui check mais bien symfony et donc meilleur affichage des erreurs

    	$builder
            ->add('username', TextType::class, array('label' => false))
            ->add('firstname', TextType::class, array('attr' => array(
             'placeholder' => 'Prénom'),'label' => false, 'required' => false))
    	    ->add('name', TextType::class, array('attr' => array(
             'placeholder' => 'Nom'),'label' => false, 'required' => false))
    	    ->add('sex', ChoiceType::class, array(
        		'choices' => array(
        			'Male' => false,
        			'Female' => true),
        		'expanded'=> true,
        		'multiple' => false,
        		'required' => false,
                'label' => false))
    	    ->add('birthDate', BirthdayType::class, array('widget' => 'choice','required' => false, 'label' => false))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'Email'),'required' => false, 'label' => false))
            ->add('emailIsPublic', CheckboxType::class,  array('required' => false, 'label' => false))
    	    ->add('phone', TextType::class, array('attr' => array('placeholder' => 'Téléphone'),'required' => false, 'label' => false))
    	    ->add('street', TextType::class, array('attr' => array('placeholder' => 'Adresse'),'required' => false, 'label' => false))
    	    ->add('postcode', TextType::class, array('attr' => array('placeholder' => 'Code Postal'),'required' => false, 'label' => false))
    	    ->add('city', TextType::class, array('attr' => array('placeholder' => 'Ville'),'required' => false, 'label' => false))
    	  //   ->add('job', EntityType::class, array(
			    // 'class'        => 'BecowoCoreBundle:Job',
			    // 'choice_label' => 'name',
			    // 'multiple'     => false,
			    // 'expanded'	   => false, 
       //          'label' => false))
            ->add('job', TextType::class, array('attr' => array('placeholder' => 'Job', 'autocomplete' => 'off', 'invalid_message' => 'That is not a valid job name'),'required' => false, 'label' => false))



    	    ->add('society', TextType::class, array('attr' => array('placeholder' => 'Société'), 'label' => false, 'required' => false))
    	    ->add('website', TextType::class, array('attr' => array(
                'placeholder' => 'URL de mon site'),
                'required' => false, 
                'label' => false))
            ->add('personnalTweet', TextType::class, array('attr' => array(
                'placeholder' => 'Mon humeur en un tweet'),
                'required' => false, 
                'label' => false))
    	    ->add('description', TextareaType::class, array('required' => false, 'label' => false, 'attr' => array('rows' => '10')))
    	    ->add('facebookLink', TextType::class, array('attr' => array(
                'placeholder' => 'Ma page ou profil Facebook'),
                'required' => false, 
                'label' => false))
    	    ->add('twitterLink', TextType::class, array('attr' => array(
                'placeholder' => 'Mon profil Twitter'),'required' => false, 'label' => false))
    	    ->add('instagramLink', TextType::class, array('attr' => array(
                'placeholder' => 'Mon profil Instagram'),'required' => false, 'label' => false))
    	    ->add('linkedinLink', TextType::class, array('attr' => array(
                'placeholder' => 'Ma page ou profil LinkedIn'),
                'required' => false, 
                'label' => false))
    	    ->add('file', FileType::class, array('multiple' => false,'required' => false, 'label' => false))
            ->add('skills', TextType::class, array('attr' => array('data-role' => 'tagsinput'),'required' => false, 'label' => false))
            ->add('hobbies', TextType::class, array('attr' => array('data-role' => 'tagsinput'),'required' => false, 'label' => false))
            ->add('wishes', TextType::class, array('attr' => array('data-role' => 'tagsinput'),'required' => false, 'label' => false))
            ;

    	$builder->remove('current_password');

        $builder->get('job')
            ->addModelTransformer(new StringToJobTransformer($this->manager));
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
