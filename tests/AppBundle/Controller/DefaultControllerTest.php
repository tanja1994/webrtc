<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Test\EnhancedWebTestCase;

class DefaultControllerTest extends EnhancedWebTestCase
{
    public function testIndexSuccess()
    {
        $this->createUser('test3');
        $client = static::createClient();

        $client->request('POST', '/hello', array(), array(), $this->getAuthorizedHeaders('test3'));

        $response = $client->getResponse();
        $this->assertEquals(201, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyEquals($response, 'key', 'value');
    }

    public function testIndexMissingToken()
    {
        $client = static::createClient();

        $client->request('POST', '/hello');

        $response = $client->getResponse();

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->headers->get('Content-Type'));
        $this->asserter()->assertResponsePropertyExists($response, 'detail');
        $this->asserter()->assertResponsePropertyEquals($response, 'title', 'Unauthorized');
    }

    public function testIndexFalseToken()
    {
        $client = static::createClient();

        $client->request('POST', '/hello', array(), array(), array('HTTP_Authorization' => 'Bearer WRONG'));

        $response = $client->getResponse();

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->headers->get('Content-Type'));
        $this->asserter()->assertResponsePropertyExists($response, 'detail');
        $this->asserter()->assertResponsePropertyEquals($response, 'title', 'Unauthorized');
    }
}