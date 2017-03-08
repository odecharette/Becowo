<?php

namespace Becowo\CoreBundle\Form\DataTransformer;

use Becowo\MemberBundle\Entity\Member;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StringToMemberTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (job) to a string (name).
     *
     * @param  Job|null $job
     * @return string
     */
    public function transform($member)
    {
        if (null === $member) {
            return '';
        }

        return $member->getName();
    }

    /**
     * Transforms a string (name) to an object (job).
     *
     * @param  string $jobName
     * @return Job|null
     * @throws TransformationFailedException if object (Job) is not found.
     */
    public function reverseTransform($memberName)
    {
        // no job name? It's optional, so that's ok
        if (!$memberName) {
            return;
        }

        $inputs = explode(',',$memberName);

        $firstname = $inputs[0];
        $name = $inputs[1];
        $city = $inputs[2];

        $member = $this->manager
            ->getRepository('BecowoMemberBundle:Member')
            ->findMemberByFirstnameNameCity($firstname, $name, $city);
        ;

        if (null === $member) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'The member with name "%s" does not exist!',
                $memberName
            ));
        }

        return $member;
    }
}
