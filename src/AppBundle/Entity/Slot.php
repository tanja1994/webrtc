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
     * @ORM\ManyToOne(targetEntity="Meeting", inversedBy="slots")
     * many slots belong to one meeting
     */
    private $meeting;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="slots" )
     * many slots belong to one student
     */
    private $student;

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
        return $this->slotStatus;
    }
    public function setSlotStatus($slotStatus)
    {
        $this->slotDate = $slotStatus;
    }


}
