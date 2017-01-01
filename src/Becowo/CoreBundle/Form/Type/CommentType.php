<?php

namespace Becowo\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use blackknight467\StarRatingBundle\Form\RatingType as RatingType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('post', TextareaType::class, array('label' => false))
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
            'data_class' => 'Becowo\CoreBundle\Entity\Comment',
            'attr' => ['id' => 'comment-form'],
            'csrf_protection' => false
        ));
    }
}
