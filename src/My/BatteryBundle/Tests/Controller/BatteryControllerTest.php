<?php

namespace My\BatteryBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class BatteryControllerTest
 *
 * @group functional
 */

class BatteryControllerTest extends WebTestCase
{

    public function testIndex()
    {
        $client = static::createClient();
        $url = $client->getContainer()->get('router')->generate('battery');
        $crawler = $client->request('GET', $url);

        $this->assertTrue($crawler->filter('html:contains("Battery list")')->count() > 0);
    }

    public function testSomeCases(){

        $client = static::createClient();
        $url = $client->getContainer()->get('router')->generate('battery_clear');
        $crawler = $client->request('GET', $url);


        $url = $client->getContainer()->get('router')->generate('battery_new');
        $crawler = $client->request('GET', $url);

        $this->assertTrue($crawler->filter('html:contains("Battery creation")')->count() > 0);


        $form = $crawler->selectButton('Create')->form(array(
            'my_batterybundle_battery[type]'  => 'AA',
            'my_batterybundle_battery[count]'  => 4,

        ));
        $client->submit($form);

        $form = $crawler->selectButton('Create')->form(array(
            'my_batterybundle_battery[type]'  => 'AAA',
            'my_batterybundle_battery[count]'  => 3,

        ));
        $client->submit($form);

        $form = $crawler->selectButton('Create')->form(array(
            'my_batterybundle_battery[type]'  => 'AA',
            'my_batterybundle_battery[count]'  => 1,

        ));
        $client->submit($form);

        $url = $client->getContainer()->get('router')->generate('battery_stats');
        $crawler = $client->request('GET', $url);

        $this->assertEquals(5, $crawler->filter('td[id="AA-container-count"]')->text(), 'Missing element AA');
        $this->assertEquals(3, $crawler->filter('td[id="AAA-container-count"]')->text(), 'Missing element AAA');

    }
}
