<?php

namespace Location\PlanBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExportControllerTest extends WebTestCase
{
    public function testJson()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/export/json');
    }

    public function testDownload()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/export/download');
    }

}
