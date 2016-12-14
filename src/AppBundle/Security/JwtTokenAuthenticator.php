<?php

namespace AppBundle\Security;

use AppBundle\Api\ApiProblem;
use AppBundle\Api\ResponseFactory;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

/**
 * @author Patrick Beckedorf
 */
class JwtTokenAuthenticator extends AbstractGuardAuthenticator
{
    /** @var JWTEncoderInterface */
    private $jwtEncoder;

    /** @var EntityManager */
    private $em;

    /** @var ResponseFactory */
    private $responseFactory;


    public function __construct(JWTEncoderInterface $jwtEncoder, EntityManager $em, ResponseFactory $responseFactory)
    {
        $this->jwtEncoder = $jwtEncoder;
        $this->em = $em;
        $this->responseFactory = $responseFactory;
    }


    public function getCredentials(Request $request)
    {
        /*$extractor = new AuthorizationHeaderTokenExtractor(
            'Bearer',
            'Authorization'
        );
        $token = $extractor->extract($request);*/

        //var_dump($request->headers);die;
        $token = $request->cookies->get('__token');
        if (!$token) {
            return;
        }
        return $token;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try{
            $data = $this->jwtEncoder->decode($credentials);
        }catch(JWTDecodeFailureException $e)
        {
            throw new CustomUserMessageAuthenticationException('Token invalide');
        }

        $user = new User();
        $user->setUsername($data['username']);
        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $apiProblem = new ApiProblem(401);
        $apiProblem->set('detail', $exception->getMessageKey());

        return $this->responseFactory->createResponse($apiProblem);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // not important as api
    }

    public function supportsRememberMe()
    {
        return false;
    }

    // called when authentication information (header) is missing from request
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $apiProblem = new ApiProblem(401);
        $message = $authException ? $authException->getMessageKey() : 'Credentials nicht vorhanden';
        $apiProblem->set('detail', $message);

        return $this->responseFactory->createResponse($apiProblem);
    }
}
