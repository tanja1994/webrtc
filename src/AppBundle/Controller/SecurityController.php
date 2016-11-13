<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{

    /**
     * @Route("/login_check", name="security_login_form")
     */
    public function indexAction($name)
    {
        return new Response('Ok');
    }
}
