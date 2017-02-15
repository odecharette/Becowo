<?php

namespace Becowo\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Becowo\CoreBundle\Repository\WorkspaceHasOfficeRepository;

class PriceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $options['idWs'];

        $builder
            ->add('workspaceHasOffice', EntityType::class, array(
                'class' => 'BecowoCoreBundle:workspaceHasOffice',
                'query_builder' => function (WorkspaceHasOfficeRepository $er) use($id) {
                return $er->createQueryBuilder('who')
                    ->andWhere('who.workspace = :id')
                    ->setParameter('id', $id)
                    ;
                },
                'choice_label' => 'name'))
            ->add('priceHour', NumberType::class, array(
                'scale' => 2))
            ->add('priceHalfDay')
            ->add('priceDay')
            ->add('priceMonth')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Becowo\CoreBundle\Entity\Price',
            'idWs' => null,
        ));
    }
}
