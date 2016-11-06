<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
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
        // replace this example code with whatever you need
        return new JsonResponse(['key' => 'value']);
    }

    // GET
    // POST (create)    : 201
    // Delete (delete)  : 204
    // PUT (update)     : 200

    // -> put + patch in one method, but within process form, change argument to:
    private function processForm(Request $request, FormInterface $form)
    {
        $data = json_decode($request->getContent(), true);
        $clearMissing = $request->getMethod() != 'PATCH';
        $form->submit($data, $clearMissing);
    }
}
