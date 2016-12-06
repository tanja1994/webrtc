<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 06.11.2016
 * Time: 23:44
 */

namespace AppBundle\Controller;

use AppBundle\Api\ApiProblem;
use AppBundle\Api\ApiProblemException;
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
    // Validation errors: 400

    // Form errors, put before dump: header('Content-type: cli');

    // -> put + patch in one method, but within process form, change argument to:
    protected function processForm(Request $request, FormInterface $form)
    {
        $data = json_decode($request->getContent(), true);
        if(null === $data)
        {
            $apiProblem = new ApiProblem(400, ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT);
            throw new ApiProblemException($apiProblem);
        }
        $clearMissing = $request->getMethod() != 'PATCH';
        $form->submit($data, $clearMissing);
    }

    // Error content type: application/problem+json
    // on an error, add the following json structure:
    // type => internal error name, e.g. 'validation_error'
    // title => human readable error, e.g. 'There was an error'
    // errors => errors
    protected function getErrorsFromForm(FormInterface $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }


    // CSRF tokens __not__ required, as stateless api.  No application with a session (no cookies on client side, and no session on server side)
    protected function throwApiProblemValidationException(FormInterface $form)
    {
        $errors = $this->getErrorsFromForm($form);

        $apiProblem = new ApiProblem(400, ApiProblem::TYPE_VALIDATION_ERROR);
        $apiProblem->set('errors', $errors);

        throw new ApiProblemException($apiProblem);
    }

    protected function createApiResponse($data, $statusCode = 200, $cookies = [])
    {
        $json = $this->serialize($data);

        $response = new Response($json, $statusCode, array(
            'Content-Type' => 'application/json'
        ));

        foreach($cookies as $cookie)
        {
            $response->headers->setCookie($cookie);
        }
        return $response;
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