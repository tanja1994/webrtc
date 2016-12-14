<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;


class TokenController extends Controller
{
    /**
     * @Route("/tokens")
     * @Method("POST")
     */
    public function newTokenAction(Request $request)
    {
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:User')
            ->findOneBy(['username' => $request->getUser()]);

        if(!$user) throw $this->createNotFoundException('User existiert nicht');

        $isValid = $this->get('security.password_encoder')->isPasswordValid($user, $request->getPassword());
        if(!$isValid) throw new BadCredentialsException('Invalide Eingabe');

        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode(['exp' => time() + 86400, 'username' => $user->getUsername(), 'id' => $user->getId()]);

       // $cookie = new Cookie('__token', $token, time() + 3600 * 24 * 7, '/', '.chor-am-killesberg.de');
        $cookie = new Cookie('__token', $token, time() + 3600 * 24 * 7, '/');

        return $this->createApiResponse(['user' => $user], 201, [$cookie]);
    }

    /**
     * @Route("/tokens")
     * @Method("DELETE")
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteTokenAction(Request $request)
    {
        if($request->cookies->has('__token'))
        {
            $response = $this->createApiResponse(['logout' => true]);
            $response->headers->clearCookie('__token', '/', null, false, true);
            return $response;
        }
        return $this->createApiResponse(['logout' => false]);
    }
}
