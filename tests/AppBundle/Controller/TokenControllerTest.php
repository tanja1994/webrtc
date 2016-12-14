<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 13.11.2016
 * Time: 15:20
 */

namespace Tests\AppBundle\Controller;


use AppBundle\Test\EnhancedWebTestCase;
use Symfony\Component\BrowserKit\Cookie;

class TokenControllerTest extends EnhancedWebTestCase
{
    public function testPostCreateToken()
    {
        $this->createUser('test');

        $client = $this->createAuthorizedClient('test', 'Test1234');
        $client->request('POST', '/tokens');
        $response = $client->getResponse();

        $this->assertEquals(201, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyExists(
            $response,
            'user'
        );

        $this->assertEquals('__token', $response->headers->getCookies()[0]->getName());
    }

    public function testPostCreateTokenInvalidCredentials()
    {
        $this->createUser('test2');

        $client = $this->createAuthorizedClient('test2', 'falsepass');
        $client->request('POST', '/tokens');
        $response = $client->getResponse();

        $this->assertEquals(401, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyEquals($response, 'detail', 'Invalid credentials.');
    }

    public function testLogout()
    {
        $this->createUser('testLogout');
        $client = static::createClient();

        $token = $this->getAuthorizedToken('testLogout');
        $cookie = new Cookie('__token', $token);
        $client->getCookieJar()->set($cookie);

        $client->request('POST', '/hello');
        $request = $client->getRequest();
        $this->assertTrue($request->cookies->has('__token'));

        $client->request('DELETE', '/tokens');
        $client->request('POST', '/hello');
        $request = $client->getRequest();
        $this->assertFalse($request->cookies->has('__token'));
    }
}