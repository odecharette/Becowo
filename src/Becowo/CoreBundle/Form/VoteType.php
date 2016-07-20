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
            // ->add('voteDate')
            // ->add('score1')
            // ->add('score2')
            // ->add('score3')
            // ->add('score4')
            // ->add('scoreAvg')
            // ->add('workspace')
            // ->add('member')
            ->add('score1', RatingType::class, ['label' => 'Rating']);
           // ->add('Submit', SubmitType::class);
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
