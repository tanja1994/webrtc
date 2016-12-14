<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 19.05.2016
 * Time: 19:35
 */

namespace AppBundle\EventListener;

use Gos\Bundle\WebSocketBundle\Event\ClientEvent;
use Gos\Bundle\WebSocketBundle\Event\ClientErrorEvent;
use Gos\Bundle\WebSocketBundle\Event\ServerEvent;
use Gos\Bundle\WebSocketBundle\Event\ClientRejectedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;

/**
 * @author Patrick Beckedorf
 */
class WebsocketEventListener
{
    /**
     * @var JWTEncoderInterface
     */
    private $encoder;


    function __construct(JWTEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Called whenever a client connects
     * @param ClientEvent $event
     */
    public function onClientConnect(ClientEvent $event)
    {
        $token = $event->getConnection()->WebSocket->request->getCookie('__token');
        if(!$token) $event->getConnection()->close();

        try{
            $decoded = $this->encoder->decode($token);
        }catch(JWTDecodeFailureException $e)
        {
            $event->getConnection()->close();
        }
    }

    /**
     * Called whenever a client disconnects
     *
     * @param ClientEvent $event
     */
    public function onClientDisconnect(ClientEvent $event)
    {
        $conn = $event->getConnection();
        // echo $conn->resourceId . " disconnected" . PHP_EOL;
    }

    /**
     * Called whenever a client errors
     */
    public function onClientError(ClientErrorEvent $event)
    {
        $conn = $event->getConnection();
        $e = $event->getException();
        // echo $e->getMessage();
    }

    /**
     * Called whenever server start
     *
     * @param ServerEvent $event
     */
    public function onServerStart(ServerEvent $event)
    {
        $event = $event->getEventLoop();
        echo 'Server was successfully started !'. PHP_EOL;
    }

    /**
     * Called whenever client is rejected by application
     *
     * @param ClientRejectedEvent $event
     */
    public function onClientRejected(ClientRejectedEvent $event)
    {
        $origin = $event->getOrigin();
        echo 'connection rejected from '. $origin . PHP_EOL;
    }
}