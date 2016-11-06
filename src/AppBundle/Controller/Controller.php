<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 06.11.2016
 * Time: 23:44
 */

namespace AppBundle\Controller;

use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
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

    protected function createApiResponse($data, $statusCode = 200)
    {
        $json = $this->serialize($data);
        return new Response($json, $statusCode, array(
            'Content-Type' => 'application/json'
        ));
    }

    // use @ExclusionPolicy within entity / model to control, what should get serialized:
    // use JMS\Serializer\Annotation as Serializer;
    // above class: @Serializer\ExclusionPolicy("all")
    // above fields that should get serialized: @Serializer\Expose
    protected function serialize($data, $format = 'json')
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);
        return $this->container->get('jms_serializer')
            ->serialize($data, $format, $context);
    }
}