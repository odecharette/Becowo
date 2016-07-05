<?php

namespace Becowo\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Becowo\CoreBundle\Entity\Faq;
use Becowo\CoreBundle\Entity\FaqCategory;

class LoadFAQ implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $cat1 = new FaqCategory();
    $cat1->setName('Catégorie 1');
    $manager->persist($cat1);

    $cat2 = new FaqCategory();
    $cat2->setName('Catégorie 2');
    $manager->persist($cat2);

    $cat3 = new FaqCategory();
    $cat3->setName('Catégorie 3');
    $manager->persist($cat3);

    $cat4 = new FaqCategory();
    $cat4->setName('Catégorie 4');
    $manager->persist($cat4);

    $cat5 = new FaqCategory();
    $cat5->setName('Catégorie 5');
    $manager->persist($cat5);

    $question = new Faq();
    $question->setCategory($cat1);
    $question->setQuestion('Pourquoi c\'est comme ca ?');
    $question->setAnswer("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
    $manager->persist($question);

    $question = new Faq();
    $question->setCategory($cat1);
    $question->setQuestion('Pourquoi c\'est comme ca ?');
    $question->setAnswer("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
    $manager->persist($question);

    $question = new Faq();
    $question->setCategory($cat1);
    $question->setQuestion('Pourquoi c\'est comme ca ?');
    $question->setAnswer("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
    $manager->persist($question);

    $question = new Faq();
    $question->setCategory($cat2);
    $question->setQuestion('Pourquoi c\'est comme ca ?');
    $question->setAnswer("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
    $manager->persist($question);

    $question = new Faq();
    $question->setCategory($cat2);
    $question->setQuestion('Pourquoi c\'est comme ca ?');
    $question->setAnswer("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
    $manager->persist($question);


    $manager->flush();
  }


}