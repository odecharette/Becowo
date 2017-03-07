<?php

namespace Becowo\CoreBundle\Form\DataTransformer;

use Becowo\CoreBundle\Entity\Job;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StringToJobTransformer implements DataTransformerInterface
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
    public function transform($job)
    {
        if (null === $job) {
            return '';
        }

        return $job->getName();
    }

    /**
     * Transforms a string (name) to an object (job).
     *
     * @param  string $jobName
     * @return Job|null
     * @throws TransformationFailedException if object (Job) is not found.
     */
    public function reverseTransform($jobName)
    {
        // no job name? It's optional, so that's ok
        if (!$jobName) {
            return;
        }

        $job = $this->manager
            ->getRepository('BecowoCoreBundle:Job')
            // query for the issue with this id
            ->findOneBy(array('name' => $jobName))
        ;

        if (null === $job) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An job with the name "%s" does not exist!',
                $jobName
            ));
        }

        return $job;
    }
}
