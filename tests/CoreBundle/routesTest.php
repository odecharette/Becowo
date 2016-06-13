<?php

namespace Becowo\Tests\CoreBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class routesTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        return array(
            array('/'),
            array('/ws/Mutualab'),
            array('/booking'),
            array('/offres'),
            array('/contact'),
            array('/apropos'),
            array('/faq'),
            array('/profile/public/olivia'),
        );
    }
}