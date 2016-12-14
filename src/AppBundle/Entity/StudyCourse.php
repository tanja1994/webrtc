<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="studycourse")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserRepository")
 */
class Studycourse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $studycourseName;


    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="studycourse")
     * many studycourses belong to many users
     */
    private $user;

    public function __construct()
    {
        $this->user = array();
    }


    public function getId()
    {
        return $this->id;
    }

    public function getStudycourseName()
    {
        return $this->studycourseName;
    }
    public function setStudycourseName($studycourseName)
    {
        $this->studycourseName = $studycourseName;
    }

}
