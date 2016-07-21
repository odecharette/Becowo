<?php

namespace Becowo\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use blackknight467\StarRatingBundle\Form\RatingType as RatingType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class VoteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('score1', RatingType::class, ['label' => 'Connectivité'])
            ->add('score2', RatingType::class, ['label' => 'Services'])
            ->add('score3', RatingType::class, ['label' => 'Cosy/Confort'])
            ->add('score4', RatingType::class, ['label' => 'Ambiance'])
            ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Becowo\CoreBundle\Entity\Vote',
            'attr' => ['id' => 'vote-form']
        ));
    }
}
