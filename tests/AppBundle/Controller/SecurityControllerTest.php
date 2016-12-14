<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Test\EnhancedWebTestCase;
use Symfony\Component\BrowserKit\Cookie;

/**
 * @author Patrick Beckedorf
 */
class SecurityControllerTest extends EnhancedWebTestCase
{
    public function testSendSuccess()
    {
        // Sender: test4; Receiver: test5
        $this->createUser('test4');
        $this->createUser('test5');
        $client = static::createClient();

        $token = $this->getAuthorizedToken('test4');
        $cookie = new Cookie('__token', $token);
        $client->getCookieJar()->set($cookie);

        $parameters = array(
            'receiver' => 'test5'
        );
        $client->request('POST', '/certificate/send', $parameters);
    }
}