<?php

namespace Becowo\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class CommunityNetworkHasMemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('member', TextareaType::class, array(
            'label' => 'Rechercher un coworker par <Prénom> <Nom>, <ville>',
            'attr' => array('rows' => '1')
            ));
                // ->add('member', EntityType::class, array(
                // 'class' => 'BecowoMemberBundle:Member',
                // 'query_builder' => function (EntityRepository $er) {
                //     return $er->createQueryBuilder('m')
                //         ->where('m.enabled = true')
                //         ->andWhere('m.isDeleted = false')
                //         ->andWhere('m.firstname IS NOT NULL')
                //         ->andWhere('m.name IS NOT NULL')
                //         ->orderBy('m.firstname', 'ASC');
                // },
                // 'choice_label' => 'fullName',
                // 'label' => 'Choisir un coworker',
                // 'expanded' => false,
                // 'multiple' => false));
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Becowo\CoreBundle\Entity\CommunityNetworkHasMember'
        ));
    }
}
