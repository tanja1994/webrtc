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

        $this->asserter()->assertResponsePropertyEquals($response, 'key', 'value');
    }
}
