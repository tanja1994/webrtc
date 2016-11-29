<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Security("has_role('ROLE_USER')")
 */
class DefaultController extends Controller
{

    /**
     * @Route("/hello", name="homepage")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $data = ['key' => 'hello'];
        return $this->createApiResponse($data, 201);
    }
}