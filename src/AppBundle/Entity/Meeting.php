<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="meeting")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\MeetingRepository")
 */
class Meeting
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\OneToMany(targetEntity="Slot", mappedBy="meeting")
     * one meeting belong to many slots
     */
    private $slot;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="meeting")
     * Many meetings belong to one professor
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $meetingStartDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $meetingEndDate;

    public function __construct()
    {
        $this->slots = array();
    }


    public function getId()
    {
        return $this->id;
    }


    public function getMeetingStartDate()
    {
        return $this->meetingStartDate;
    }

    public function setMeetingStartDate($meetingStartDate)
    {
        $this->meetingStartDate = $meetingStartDate;
    }

    public function getMeetingEndDate()
    {
        return $this->meetingEndDate;
    }

    public function setMeetingEndDate($meetingEndDate)
    {
        $this->meetingEndDate = $meetingEndDate;
    }

}
