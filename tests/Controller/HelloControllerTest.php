<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HelloControllerTest extends WebTestCase
{
    public function testHelloPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/hello');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Hello World!');
    }
}
