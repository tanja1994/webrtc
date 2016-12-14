<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Security("has_role('ROLE_USER')")
 * @author Patrick Beckedorf
 */
class SecurityController extends Controller
{
    /**
     * @Route("/certificate", name="security_certificate")
     * @Method("POST")
     */
    public function certificateAction(Request $request)
    {
        $this->get('logger')->debug('STARTED');
        $em = $this->get('doctrine.orm.entity_manager');
        $userRepo = $em->getRepository('AppBundle:User');

        // Parameter ob channel key
        $key = $request->request->get('key');
        $this->get('logger')->debug('KEY: ' . $key);
        if($key != 'certificate_request' && $key != 'certificate_response')
        {
            return $this->createApiResponse(['error' => 'Invalid key']);
        }

        // username of user that should get called
        $receiverId = $request->request->get('receiver');
        $receiver = $em->getRepository('AppBundle:User')
            ->find($receiverId);

        if(!$receiver) {
            return $this->createApiResponse(['error' => 'Invalid receiver']);
        }

        $receiverId = $receiver->getId();

        // Userid of current logged user
        $senderEmail = $this->getUser()->getUsername();
        $senderId = $userRepo->findOneBy(['username' => $senderEmail])
                             ->getId();

        // certificate of sender
        $certificate = $request->request->get('certificate');

        // Push to receiver channel
        $pusher = $this->get('gos_web_socket.zmq.pusher');
        $pusher->push([
            'user'      =>  $receiverId,
            'message'   => ['key' => $key, 'sender' => $senderId, 'certificate' => $certificate]
        ], 'signaling_topic', [ 'user_id' => $receiverId ]);

        return $this->createApiResponse(['sent']);
    }
}
