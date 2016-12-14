<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class User implements UserInterface
{
    const ROLE_DEFAULT = 'ROLE_USER';
    const ROLE_STUDENT = 'ROLE_STUDENT';
    const ROLE_PROF = 'ROLE_PROF';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Serializer\Expose
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Expose
     */
    private $firstname;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Expose
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     * @Serializer\Expose
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="Slot", mappedBy="student")
     * one student belong to many slots
     */
    private $slots;

    /**
     * @ORM\OneToMany(targetEntity="Meeting", mappedBy="professor")
     * one professor belong to many meetings
     */
    private $meetings;

    /**
     * @ORM\ManyToMany(targetEntity="Studycourse", mappedBy="users")
     * many user belong to many study courses
     */
    private $studycourses;


    public function __construct()
    {
        $this->roles = array();
        $this->slots = new ArrayCollection();
        $this->meetings = new ArrayCollection();
        $this->studycourses = new ArrayCollection();
    }


    public function getRoles()
    {
        $roles = $this->roles;
        // we need to make sure to have at least one role
        $roles[] = static::ROLE_DEFAULT;
        return array_unique($roles);
    }


    public function addRole($role)
    {
        $role = strtoupper($role);
        if ($role === static::ROLE_DEFAULT) {
            return $this;
        }
        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {

        $this->title = $title;
    }


    public function getSalt()
    {
        return;
    }

    public function eraseCredentials()
    {
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
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

    public function getMeetings()
    {
        return $this->meetings;
    }

    public function addMeeting(Meeting $meeting)
    {
        if(!$this->meetings->contains($meeting))
        {
            $this->meetings->add($meeting);
        }
    }

    public function removeMeeting(Meeting $meeting)
    {
        if($this->meetings->contains($meeting))
        {
            $this->meetings->remove($meeting);
        }
    }

    public function getStudycourses()
    {
        return $this->studycourses;
    }

    public function addStudyCourse(Studycourse $studycourse)
    {
        if(!$this->studycourses->contains($studycourse))
        {
            $this->studycourses->add($studycourse);
        }
    }

    public function removeStudyCourse(Studycourse $studycourse)
    {
        if($this->studycourses->contains($studycourse))
        {
            $this->studycourses->remove($studycourse);
        }
    }
}
