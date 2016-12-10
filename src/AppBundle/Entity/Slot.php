<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="slot")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserRepository")
 */
class Slot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $slotname;

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
    private $slotStatus =array("requested", "accepted", "declined");

    public function getId()
    {
        return $this->id;
    }

    public function getSlotname()
    {
        return $this->slotname;
    }
    public function setSlotname($slotname)
    {
        $this->username = $slotname;
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
        return $this->slotStatus;
    }
    public function setSlotStatus($slotStatus)
    {
        $this->slotStatus = $slotStatus;
    }


}
