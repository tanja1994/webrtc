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
    const ROLE_DEFAULT = 'ROLE_USER';
    const ROLE_STUDENT = 'ROLE_STUDENT';
    const ROLE_PROF = 'ROLE_PROF';

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
     * @ORM\Column(type="array")
     * @Serializer\Expose
     */
    private $roles;

    /**
     * @ORM\Column(type="string")
     */
    private $lectures;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    public function __construct()
    {
        $this->lectures = array();
        $this->userRole = array();
        $this->studycourse = array ();
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

    public function getSalt()
    {
        return;
    }

    public function eraseCredentials()
    {
    }
}
