<?php

namespace Becowo\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Becowo\CoreBundle\Repository\WorkspaceHasOfficeRepository;

// Ce form type est utilisé dans l'interface des manager, pour créer une réservation hors becowo

class BookingManagerType extends AbstractType
{
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
                'choice_label' => 'name',
                'label' => 'Bureau'))
            ->add('startDate', DateTimeType::class, array('label' => 'Date de début', 'years' => range(date('Y'), date('Y')+2)))
            ->add('endDate', DateTimeType::class, array('label' => 'Date de fin', 'years' => range(date('Y'), date('Y')+2)))
            ->add('priceExclTax', NumberType::class, array(
                'scale' => 2,
                'label' => 'Prix € HC'))
            ->add('priceInclTax', NumberType::class, array(
                'scale' => 2,
                'label' => 'Prix € TTC'))
            ->add('duration', ChoiceType::class, array(
                'label'=> 'Durée',
                'choices'  => array(
                    'Heure' => 'Heure',
                    '1/2 journée' => '1/2 journée',
                    'Journée' => 'Journée',
                    'Mois' => 'Mois'
                )))
            ->add('duration_day', ChoiceType::class, array(
                'label' => 'Si 1/2 journée, préciser matin ou après-midi',
                'choices'  => array(
                    ' ' => null,
                    'Matin' => 'Matin',
                    'Après-midi' => 'Après-midi'
                )))
            ->add('nbPeople', NumberType::class, array(
                'scale' => 0,
                'label' => 'Nombre de coworkers'))
            ->add('status', EntityType::class, array(
                'class' => 'BecowoCoreBundle:Status',
                'choice_label' => 'name',
                'label' => 'Statut'))
            ->add('Ajouter', SubmitType::class)
            ;
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Becowo\CoreBundle\Entity\Booking',
            'idWs' => null,
        ));
    }
}
