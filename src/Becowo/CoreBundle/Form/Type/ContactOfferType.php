<?php

namespace Becowo\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContactOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contactName', TextType::class, array('label' => false, 'required' => false))
            ->add('offer', ChoiceType::class, array(
                'choices' => array('Link' => 'Link', 'Zen' => 'Zen', 'Option Data' => 'Option Data', 'Visite à 360°' => 'Visite à 360°'),
                'label' => false, 
                'required' => false))
            ->add('wsName', TextType::class, array('label' => false))
            ->add('email', EmailType::class, array('label' => false))
            ->add('street', TextType::class, array('label' => false, 'required' => false))
            ->add('postCode', TextType::class, array('label' => false, 'required' => false))
            ->add('city', TextType::class, array('label' => false, 'required' => false))
            ->add('phone', TextType::class, array('label' => false, 'required' => false))
            ->add('nbDesk', IntegerType::class, array('label' => false, 'required' => false))
            ->add('comments', TextareaType::class, array('label' => false, 'required' => false, 'attr' => array('rows' => '8')));
            // ->add('envoyer', SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Becowo\CoreBundle\Entity\ContactOffer'
        ));
    }
}
