<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 26.10.2016
 * Time: 11:14
 */

namespace AppBundle\Topic;

use Gos\Bundle\WebSocketBundle\Topic\PushableTopicInterface;
use Gos\Bundle\WebSocketBundle\Topic\TopicInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;
use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Patrick Beckedorf
 */
class SignalingTopic implements TopicInterface, PushableTopicInterface
{

    /** @var Request */
    private $request;

    /**
     * @var JWTEncoderInterface
     */
    private $encoder;

    private $clients = [];

    function __construct(JWTEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

/**
 * This will receive any Subscription requests for this topic.
 *
 * @param ConnectionInterface $connection
 * @param Topic $topic
 * @param WampRequest $request
 * @return void
 */
    public function onSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        $token = $connection->WebSocket->request->getCookie('__token');
        $decoded = [];
        if(!$token) $connection->getConnection()->close();

        try{
            $decoded = $this->encoder->decode($token);
        }catch(JWTDecodeFailureException $e)
        {
            $connection->close();
        }

        $userid = $request->getAttributes()->get('user_id');
        if(count($decoded) > 0 && isset($decoded['id']) && $decoded['id'] != $userid)
        {
            $topic->remove($connection);
            return false;
        }

        // add user to topic store manually
        $this->clients['user' . $userid] = $connection;
        $topic->broadcast(['msg' => $connection->resourceId . " has joined " . $topic->getId()]);
    }

    /**
     * This will receive any UnSubscription requests for this topic.
     *
     * @param ConnectionInterface $connection
     * @param Topic $topic
     * @param WampRequest $request
     * @return void
     */
    public function onUnSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        //this will broadcast the message to ALL subscribers of this topic.
        $topic->broadcast(['msg' => $connection->resourceId . " has left " . $topic->getId()]);
    }


    /**
     * This will receive any Publish requests for this topic.
     *
     * @param ConnectionInterface $connection
     * @param Topic $topic
     * @param WampRequest $request
     * @param $event
     * @param array $exclude
     * @param array $eligible
     * @return mixed|void
     */
    public function onPublish(ConnectionInterface $connection, Topic $topic, WampRequest $request, $event, array $exclude, array $eligible)
    {
        // In this application if clients send data it's because the user hacked around in console

        // Close connection:  $connection->close();
        // Better: Just do nothing
        return;
    }

    /**
     * @param Topic        $topic
     * @param WampRequest  $request
     * @param array|string $data (userid)
     * @param string       $provider The name of pusher who push the data
     */
    public function onPush(Topic $topic, WampRequest $request, $data, $provider)
    {
        $this->clients['user' . $data['user']]->event($topic->getId(), stripslashes(json_encode($data['message'])));
        //$topic->broadcast(json_encode($data['message']));
    }


    /**
     * Like RPC is will use to prefix the channel
     * @return string
     */
    public function getName()
    {
        return 'signaling.topic';
    }
}