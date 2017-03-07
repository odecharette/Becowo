<?php

namespace Becowo\CoreBundle\Form\DataTransformer;

use Becowo\CoreBundle\Entity\Wish;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

class CollectionToWishTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (wish) to a string (name).
     *
     * @param  wish|null $wish
     * @return string
     */
    public function transform($wish)
    {
        if (null === $wish) {
            return '';
        }
        // Ici wish est un tableau d'objet car on est sur une relation many to many
        $list = '';
        foreach($wish as $s)
        {
            $list = $list . $s->getName() . ', ';
        }
        return $list;
    }

    /**
     * Transforms a string (name) to an object (wish).
     *
     * @param  string $wishName
     * @return PersistentCollection|ArrayCollection
     */
    public function reverseTransform($listWishesName)
    {
        // no wish name? It's optional, so that's ok
        if (!$listWishesName) {
             return new ArrayCollection();
        }
        $listWishesName = explode(',', $listWishesName);
        $tabWishes = new ArrayCollection();

        foreach($listWishesName as $wishName)
        {
            $wishName = trim(str_replace(',', '', $wishName));
            $wish = $this->manager
                        ->getRepository('BecowoCoreBundle:Wish')
                        ->findOneBy(array('name' => $wishName))
                    ;

            if (null === $wish) {
                // Si le wish n'existe pas on le crée
                $newWish = new Wish();
                $newWish->setName($wishName);
                $this->manager->persist($newWish);
                $wish = $newWish;
            }

            $tabWishes->add($wish);
        }
        return $tabWishes;
    }
}
