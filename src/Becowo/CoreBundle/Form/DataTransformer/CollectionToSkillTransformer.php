<?php

namespace Becowo\CoreBundle\Form\DataTransformer;

use Becowo\CoreBundle\Entity\Skill;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

class CollectionToSkillTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (skill) to a string (name).
     *
     * @param  skill|null $skill
     * @return string
     */
    public function transform($skill)
    {
        if (null === $skill) {
            return '';
        }
        // Ici skill est un tableau d'objet car on est sur une relation many to many
        $list = '';
        foreach($skill as $s)
        {
            $list = $list . $s->getName() . ', ';
        }
        return $list;
    }

    /**
     * Transforms a string (name) to an object (skill).
     *
     * @param  string $jobName
     * @return PersistentCollection|ArrayCollection
     */
    public function reverseTransform($listSkillName)
    {
        // no skill name? It's optional, so that's ok
        if (!$listSkillName) {
             return new ArrayCollection();
        }

dump($listSkillName);
        $listSkillName = explode(', ', substr($listSkillName, 0, -1));
        $tabSkills = new ArrayCollection();

        foreach($listSkillName as $skillName)
        {
            $skill = $this->manager
                        ->getRepository('BecowoCoreBundle:Skill')
                        ->findOneBy(array('name' => $skillName))
                    ;

            if (null === $skill) {
                // Si le skill n'existe pas on le crée
                $newSkill = new Skill();
                $newSkill->setName($skillName);
                $this->manager->persist($newSkill);
                $skill = $newSkill;
            }

            $tabSkills->add($skill);
        }
dump($tabSkills);
        // return new PersistentCollection($this->manager, Skill::class, new ArrayCollection($tabSkills));
        return $tabSkills;
    }
}
