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
        $em = $this->get('doctrine.orm.entity_manager');
        $userRepo = $em->getRepository('AppBundle:User');

        // username of user that should get called
        $receiverEmail = $request->request->get('receiver');
        $receiver = $em->getRepository('AppBundle:User')
            ->findOneBy(['username' => $receiverEmail]);

        if(!$receiver) return;
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
            'user' =>  $receiverId,
            'message' => ['sender' => $senderId, 'certificate' => $certificate]
        ], 'signaling_topic', [ 'user_id' => $receiverId ]);

        return $this->createApiResponse(['sent']);
    }
}
