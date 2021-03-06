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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Becowo\CoreBundle\Form\Type\ProfilePictureType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Becowo\CoreBundle\Form\DataTransformer\StringToJobTransformer;
use Becowo\CoreBundle\Form\DataTransformer\CollectionToSkillTransformer;
use Becowo\CoreBundle\Form\DataTransformer\CollectionToHobbieTransformer;
use Becowo\CoreBundle\Form\DataTransformer\CollectionToWishTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;

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
// 'error_bubbling' => true permet d'envoyer l'erreur au niveau de la form plutôt qu'au niveau du field
    // permet un affichage centralisé des erreurs avec form_errors(form)
    	$builder
            ->add('username', TextType::class, array('label' => false, 'error_bubbling' => true))
            ->add('firstname', TextType::class, array('attr' => array(
             'placeholder' => 'Prénom'),'label' => false, 'required' => false, 'error_bubbling' => true))
    	    ->add('name', TextType::class, array('attr' => array(
             'placeholder' => 'Nom'),'label' => false, 'required' => false, 'error_bubbling' => true))
    	    ->add('sex', ChoiceType::class, array(
        		'choices' => array(
        			'Male' => false,
        			'Female' => true),
        		'expanded'=> true,
        		'multiple' => false,
        		'required' => false,
                'label' => false, 
                'error_bubbling' => true))
    	    ->add('birthDate', BirthdayType::class, array('widget' => 'choice','required' => false, 'label' => false, 'error_bubbling' => true))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'Email'),'required' => false, 'label' => false, 'error_bubbling' => true))
            ->add('emailIsPublic', CheckboxType::class,  array('required' => false, 'label' => false, 'error_bubbling' => true))
    	    ->add('phone', TextType::class, array('attr' => array('placeholder' => 'Téléphone'),'required' => false, 'label' => false, 'error_bubbling' => true))
    	    ->add('street', TextType::class, array('attr' => array('placeholder' => 'Adresse'),'required' => false, 'label' => false, 'error_bubbling' => true))
    	    ->add('postcode', TextType::class, array('attr' => array('placeholder' => 'Code Postal'),'required' => false, 'label' => false, 'error_bubbling' => true))
    	    ->add('city', TextType::class, array('attr' => array('placeholder' => 'Ville'),'required' => false, 'label' => false, 'error_bubbling' => true))
            ->add('country', EntityType::class, array(
                'class' => 'BecowoCoreBundle:Country',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'placeholder' => 'Choisir un pays',
                'empty_data'  => null,
                'choice_label' => 'name',
                'required' => false,
                'label' => false, 
                'error_bubbling' => true))
            ->add('job', TextType::class, array('attr' => array('placeholder' => 'Job', 'autocomplete' => 'off'),'required' => false, 'label' => false, 'error_bubbling' => true))
    	    ->add('society', TextType::class, array('attr' => array('placeholder' => 'Société'), 'label' => false, 'required' => false, 'error_bubbling' => true))
    	    ->add('website', TextType::class, array('attr' => array(
                'placeholder' => 'URL de mon site'),
                'required' => false, 
                'label' => false, 
                'error_bubbling' => true))
            ->add('personnalTweet', TextType::class, array('attr' => array(
                'placeholder' => 'Mon humeur en un tweet'),
                'required' => false, 
                'label' => false, 
                'error_bubbling' => true))
    	    ->add('description', TextareaType::class, array('required' => false, 'label' => false, 'error_bubbling' => true, 'attr' => array('rows' => '10')))
    	    ->add('facebookLink', TextType::class, array('attr' => array(
                'placeholder' => 'Ma page ou profil Facebook'),
                'required' => false, 
                'label' => false, 
                'error_bubbling' => true))
    	    ->add('twitterLink', TextType::class, array('attr' => array(
                'placeholder' => 'Mon profil Twitter'),'required' => false, 'label' => false, 'error_bubbling' => true))
    	    ->add('instagramLink', TextType::class, array('attr' => array(
                'placeholder' => 'Mon profil Instagram'),'required' => false, 'label' => false, 'error_bubbling' => true))
    	    ->add('linkedinLink', TextType::class, array('attr' => array(
                'placeholder' => 'Ma page ou profil LinkedIn'),
                'required' => false, 
                'label' => false, 
                'error_bubbling' => true))
    	    ->add('file', FileType::class, array('multiple' => false,'required' => false, 'label' => false, 'error_bubbling' => true))
            ->add('listSkills', TextType::class, array('attr' => array('data-role' => 'tagsinput', 'placeholder' => 'Saisir une compétence et appuyer sur Enter', 'autocomplete' => 'off'),'required' => false, 'label' => false, 'error_bubbling' => true))
            ->add('listHobbies', TextType::class, array('attr' => array('data-role' => 'tagsinput', 'placeholder' => 'Saisir un centre d\'intérêt et appuyer sur Enter', 'autocomplete' => 'off'),'required' => false, 'label' => false, 'error_bubbling' => true))
            ->add('listWishes', TextType::class, array('attr' => array('data-role' => 'tagsinput', 'placeholder' => 'Saisir un souhait et appuyer sur Enter', 'autocomplete' => 'off'),'required' => false, 'label' => false, 'error_bubbling' => true))
            ->add('sendNewsletter', CheckboxType::class,  array('required' => false, 'label' => false, 'error_bubbling' => true))
            ;

    	$builder->remove('current_password');

        $builder->get('job')
            ->addModelTransformer(new StringToJobTransformer($this->manager));

        $builder->get('listSkills')
            ->addModelTransformer(new CollectionToSkillTransformer($this->manager));

        $builder->get('listHobbies')
            ->addModelTransformer(new CollectionToHobbieTransformer($this->manager));

        $builder->get('listWishes')
            ->addModelTransformer(new CollectionToWishTransformer($this->manager));

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
