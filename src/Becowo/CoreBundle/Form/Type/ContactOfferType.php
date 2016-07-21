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

class ContactOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('wsName', TextType::class, array('label' => 'Nom de l\'espace'))
            ->add('email', EmailType::class, array('label' => 'Email de contact'))
            ->add('street', TextType::class, array('label' => 'Adresse', 'required' => false))
            ->add('postCode', TextType::class, array('label' => 'Code postal', 'required' => false))
            ->add('city', TextType::class, array('label' => 'Ville', 'required' => false))
            ->add('phone', TextType::class, array('label' => 'Téléphone', 'required' => false))
            ->add('nbDesk', IntegerType::class, array('label' => 'Nombre de postes proposés', 'required' => false))
            ->add('comments', TextareaType::class, array('label' => 'Commentaires', 'required' => false))
            ->add('envoyer', SubmitType::class);
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
