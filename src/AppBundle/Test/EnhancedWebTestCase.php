<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 06.11.2016
 * Time: 22:29
 */

namespace AppBundle\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EnhancedWebTestCase extends WebTestCase
{
    private $asserter;

    protected function createAuthorizedClient($email, $password)
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => $email,
            'PHP_AUTH_PW'   => $password
        ));

        $client->getContainer()->get('session')->set('logged', true);
        return $client;
    }

    // singleton
    protected function asserter()
    {
        if($this->asserter == null)
        {
            $this->asserter = new ResponseAsserter();
        }
        return $this->asserter;
    }
}