<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="slot")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\SlotRepository")
 */
class Slot
{
    const SLOTSTATUS_ACCEPTED = 'ACCEPTED';
    const SLOTSTATUS_DECLINED = 'DECLINED';
    const SLOTSTATUS_REQUESTED = 'REQUESTED';


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $slotName;

    /**
     * @ORM\ManyToOne(targetEntity="Meeting", inversedBy="slot")
     * many slots belong to one meeting
     */
    private $meeting;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="slot")
     * many slots belong to one student
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $slotTime;

    /**
     * @ORM\Column(type="datetime")
     */
    private $slotDate;

    /**
     * @ORM\Column(type="string")
     */
    private $slotComment;

    /**
     * @ORM\Column(type="string")
     */
    private $slotStatus;

    public function __construct()
    {
        $this->slotStatus = array();
    }




    public function getId()
    {
        return $this->id;
    }

    public function getSlotName()
    {
        return $this->slotName;
    }
    public function setSlotName($slotName)
    {
        $this->slotName = $slotName;
    }


    public function getSlotTime()
    {
        return $this->slotTime;
    }
    public function setSlotTime($slotTime)
    {
        $this->slotTime = $slotTime;
    }

    public function getSlotDate()
    {
        return $this->slotDate;
    }
    public function setSlotDate($slotDate)
    {
        $this->slotDate = $slotDate;
    }

    public function getSlotStatus()
    {
        $slotStatus = $this->slotStatus;

        //Before the professor has accepted the slot, the slot has the status requested
        $slotStatus[] = static::SLOTSTATUS_REQUESTED;

        return array_unique($slotStatus);

        return $this->slotStatus;
    }
    public function setSlotStatus($slotStatus)
    {
        $this->slotStatus = $slotStatus;
    }


}
