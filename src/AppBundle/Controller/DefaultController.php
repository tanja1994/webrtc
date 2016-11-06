<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/api/hello", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $data = ['key' => 'value'];
        return $this->createApiResponse($data);
    }
}