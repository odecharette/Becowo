<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Becowo\CoreBundle\BecowoCoreBundle(),
            new Becowo\MemberBundle\BecowoMemberBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new \JMS\SerializerBundle\JMSSerializerBundle(),
            new \FOS\ElasticaBundle\FOSElasticaBundle(),
            new JavierEguiluz\Bundle\EasyAdminBundle\EasyAdminBundle(),
            new Becowo\ManagerBundle\BecowoManagerBundle(),
            new CMEN\GoogleChartsBundle\CMENGoogleChartsBundle(),
            new blackknight467\StarRatingBundle\StarRatingBundle(),
            new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),
            new SunCat\MobileDetectBundle\MobileDetectBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Becowo\ApiBundle\BecowoApiBundle(),
            new Algolia\AlgoliaSearchBundle\AlgoliaAlgoliaSearchBundle(),
            new Becowo\CronBundle\BecowoCronBundle(),
            new CoreSphere\ConsoleBundle\CoreSphereConsoleBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'demo'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
