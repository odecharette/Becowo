<?php

namespace Becowo\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Becowo\CoreBundle\Repository\WorkspaceHasOfficeRepository;

class PriceInCreateWSType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('priceHour', NumberType::class, array(
                'scale' => 2,
                'label' => 'Prix à l\'heure (€ HT)',
                'required' => false))
            ->add('priceHalfDay', NumberType::class, array(
                'scale' => 2,
                'label' => 'Prix à la demi-journée (€ HT)',
                'required' => false))
            ->add('priceDay', NumberType::class, array(
                'scale' => 2,
                'label' => 'Prix à la journée (€ HT)',
                'required' => false))
            ->add('priceMonth', NumberType::class, array(
                'scale' => 2,
                'label' => 'Prix au mois (€ HT)',
                'required' => false))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Becowo\CoreBundle\Entity\Price',
        ));
    }
}
