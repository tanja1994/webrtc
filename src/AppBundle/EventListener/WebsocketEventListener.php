<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 19.05.2016
 * Time: 19:35
 */

namespace AppBundle\EventListener;

use Gos\Bundle\WebSocketBundle\Client\ClientManipulator;
use Gos\Bundle\WebSocketBundle\Event\ClientEvent;
use Gos\Bundle\WebSocketBundle\Event\ClientErrorEvent;
use Gos\Bundle\WebSocketBundle\Event\ServerEvent;
use Gos\Bundle\WebSocketBundle\Event\ClientRejectedEvent;
use Guzzle\Http\Message\RequestInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class WebsocketEventListener
{

    /**
     * @var ClientManipulator
     */
    private $clientManipulator;


    function __construct(ClientManipulator $clientManipulator)
    {
        $this->clientManipulator = $clientManipulator;
    }

    /**
     * Called whenever a client connects
     * @param ClientEvent $event
     */
    public function onClientConnect(ClientEvent $event)
    {
        $connection = $event->getConnection();
        $user = $this->clientManipulator->getClient($connection);

        echo "ja";
        var_dump($user);die;
        /*$header = (string) $request->getHeader('Origin');
        $origin = parse_url($header, PHP_URL_HOST) ?: $header;
        die("ORIGIN: " . $origin);*/
        //VARr_dump($event->getConnection()->WebSocket->request->getHeader('Authorization'));die;
        /*$extractor = new AuthorizationHeaderTokenExtractor(
            'Bearer',
            'Authorization'
        );

        $token = $extractor->extract($this->request);

        // Prüfen, ob user authentifiziert ist. Wenn nicht, Websocket schließen
        if(!($token))
        {
            $event->getConnection()->close();
        }*/
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