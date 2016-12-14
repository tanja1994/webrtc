<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="slot")
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("all")
 */

class Slot
{
      /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Expose
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Expose
     */
    private $time;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Expose
     */
    private $dte;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Expose
     */
    private $comment;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Expose
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Meeting", inversedBy="slots")
     * many slots belong to one meeting
     */
    private $meeting;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="slots")
     * many slots belong to one student
     */
    private $student;


    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time)
    {
        $this->time = $time;
    }

    public function getDte()
    {
        return $this->dte;
    }

    public function setDte($dte)
    {
        $this->dte = $dte;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getMeeting()
    {
        return $this->meeting;
    }

    public function setMeeting($meeting)
    {
        $this->meeting = $meeting;
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function setStudent($student)
    {
        $this->student = $student;
    }
}
