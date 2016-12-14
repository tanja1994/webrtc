<?php

namespace AppBundle\Entity;

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
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $usersurname;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Serializer\Expose
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="Slot", mappedBy="student")
     * one student belong to many slots
     */
    private $slots;
    /**
     * @ORM\Column(type="array")
     * @Serializer\Expose
     */
    private $roles;

    private $studyCourses;

    private $title;


    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->roles = array();
        $this->lectures = array();
        $this->studycourse = array ();
    }

    /**
     * @ORM\OneToMany(targetEntity="Meeting", mappedBy="professor")
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
    private $lectures;

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


    public function setUserRole($role)
    {
        $this->roles = $role;
    }

    public function getLecture()
    {
        return $this->lectures;
    }
    public function setLecture($lectures)
    {
        $this->lectures = $lectures;
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
