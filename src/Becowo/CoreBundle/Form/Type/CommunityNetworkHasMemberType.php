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
use Becowo\CoreBundle\Form\DataTransformer\StringToMemberTransformer;
use Doctrine\Common\Persistence\ObjectManager;

class CommunityNetworkHasMemberType extends AbstractType
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('member', TextType::class, array('attr' => array('autocomplete' => 'off'),'required' => false, 'label' => 'Rechercher un coworker par <Prénom> <Nom>, <ville>'));


        $builder->get('member')
            ->addModelTransformer(new StringToMemberTransformer($this->manager));
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
