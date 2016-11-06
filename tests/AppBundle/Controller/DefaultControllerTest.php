<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Test\EnhancedWebTestCase;

class DefaultControllerTest extends EnhancedWebTestCase
{

    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/api/hello');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('key', json_decode($response->getContent(), true));
    }
}
