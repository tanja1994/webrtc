<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="meeting")
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("all")
 */
class Meeting
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Expose
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Expose
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Expose
     */
    private $endDate;

    /**
     * @ORM\OneToMany(targetEntity="Slot", mappedBy="meeting")
     * one meeting belong to many slots
     */
    private $slots;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="meetings")
     * Many meetings belong to one professor
     */
    private $professor;


    public function __construct()
    {
        $this->slots = new ArrayCollection();
    }


    public function getId()
    {
        return $this->id;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    public function getSlots()
    {
        return $this->slots;
    }

    public function addSlot(Slot $slot)
    {
        if(!$this->slots->contains($slot))
        {
            $this->slots->add($slot);
        }
    }

    public function removeSlot(Slot $slot)
    {
        if($this->slots->contains($slot))
        {
            $this->slots->remove($slot);
        }
    }

    public function getProfessor()
    {
        return $this->professor;
    }

    public function setProfessor($professor)
    {
        $this->professor = $professor;
    }
}
