<?php

namespace My\BatteryBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class BatteryControllerTest
 *
 * @group functional
 */
class BatteryControllerTest extends WebTestCase
{

    private $client;


    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testIndex()
    {
        $url = $this->client->getContainer()->get('router')->generate('battery');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($crawler->filter('html:contains("Battery list")')->count() > 0);
    }


    public function testClear()
    {

        $url = $this->client->getContainer()->get('router')->generate('battery_clear');
        $this->client->request('GET', $url);

        $url = $this->client->getContainer()->get('router')->generate('battery');
        $this->assertTrue($this->client->getResponse()->isRedirect($url));
    }


    /**
     * @dataProvider addProvider
     * @depends      testClear
     *
     */
    public function testAdd($type, $count)
    {

        $url = $this->client->getContainer()->get('router')->generate('battery_new');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($crawler->filter('html:contains("Battery creation")')->count() > 0);


        $form = $crawler->selectButton('Create')->form(array(
            'my_batterybundle_battery[type]' => $type,
            'my_batterybundle_battery[count]' => $count,

        ));
        $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirection());
    }

    /**
     * @depends testAdd
     *
     */
    public function testStat()
    {

        $url = $this->client->getContainer()->get('router')->generate('battery_stats');
        $crawler = $this->client->request('GET', $url);

        $this->assertEquals(5, $crawler->filter('td[id="AA-container-count"]')->text(), 'Missing element AA');
        $this->assertEquals(3, $crawler->filter('td[id="AAA-container-count"]')->text(), 'Missing element AAA');
    }


    public function addProvider()
    {
        return [
            ['AA', 4],
            ['AAA', 3],
            ['AA', 1],
        ];
    }

}
