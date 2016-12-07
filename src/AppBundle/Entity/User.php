<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserRepository")
 */
class User implements UserInterface
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
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $usersurname;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="Slot", mappedBy="user")
     * one student belong to many slots
     */
    private $slot;

    /**
     * @ORM\OneToMany(targetEntity="Meeting", mappedBy="user")
     * one professor belong to many meetings
     */
    private $meeting;

    /**
     * @ORM\ManyToMany(targetEntity="Studycourse", mappedBy="user")
     * many user belong to many study courses
     */
    private $studycourse;

    /**
     * @ORM\Column(type="string")
     */
    private $userRole =array("Student", "Professor");

    /**
     * @ORM\Column(type="string")
     */
    private $lecture;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

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
    public function getUserSurname()
    {
        return $this->userSurname;
    }
    public function setUserSurname($userSurname)
    {
        $this->userSurname = $userSurname;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getUserRole()
    {
        return $this->userRole;
    }
    public function setUserRole($userRole)
    {
        $this->userRole = $userRole;
    }

    public function getLecture()
    {
        return $this->lecture;
    }
    public function setLecture($lecture)
    {
        $this->lecture = $lecture;
    }

    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        return;
    }

    public function eraseCredentials()
    {
    }
}
