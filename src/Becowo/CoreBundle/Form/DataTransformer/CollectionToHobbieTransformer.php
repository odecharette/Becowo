<?php

namespace Becowo\CoreBundle\Form\DataTransformer;

use Becowo\CoreBundle\Entity\Hobbie;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

class CollectionToHobbieTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (hobbie) to a string (name).
     *
     * @param  hobbie|null $hobbie
     * @return string
     */
    public function transform($hobbie)
    {
        if (null === $hobbie) {
            return '';
        }
        // Ici hobbie est un tableau d'objet car on est sur une relation many to many
        $list = '';
        foreach($hobbie as $s)
        {
            $list = $list . $s->getName() . ', ';
        }
        return $list;
    }

    /**
     * Transforms a string (name) to an object (hobbie).
     *
     * @param  string $hobbieName
     * @return PersistentCollection|ArrayCollection
     */
    public function reverseTransform($listHobbieName)
    {
        // no hobbie name? It's optional, so that's ok
        if (!$listHobbieName) {
             return new ArrayCollection();
        }
        $listHobbieName = explode(',', $listHobbieName);
        $tabHobbies = new ArrayCollection();

        foreach($listHobbieName as $hobbieName)
        {
            $hobbieName = trim(str_replace(',', '', $hobbieName));
            $hobbie = $this->manager
                        ->getRepository('BecowoCoreBundle:Hobbie')
                        ->findOneBy(array('name' => $hobbieName))
                    ;

            if (null === $hobbie) {
                // Si le hobbie n'existe pas on le crée
                $newHobbie = new Hobbie();
                $newHobbie->setName($hobbieName);
                $this->manager->persist($newHobbie);
                $hobbie = $newHobbie;
            }

            $tabHobbies->add($hobbie);
        }
        return $tabHobbies;
    }
}
