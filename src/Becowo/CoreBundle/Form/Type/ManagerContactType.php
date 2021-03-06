<?php

namespace Becowo\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ManagerContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => false, 'required' => false))
            ->add('email', EmailType::class, array('label' => false, 'required' => false))
            ->add('subject', TextType::class, array('label' => false, 'required' => false))
            ->add('message', TextareaType::class, array('label' => false, 'required' => false, 'attr' => array('rows' => '8')));
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Becowo\CoreBundle\Entity\Contact',
            'attr' => ['id' => 'manager-contact-form']
        ));
    }
}
