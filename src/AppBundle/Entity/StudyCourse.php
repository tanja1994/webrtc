<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="studycourse")
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("all")
 */
class Studycourse
{
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="studycourses")
     * many studycourses belong to many users
     */
    private $users;


    public function __construct()
    {
        $this->users = new ArrayCollection();
    }


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

    public function getUsers()
    {
        return $this->users;
    }

    public function addUser(User $user)
    {
        if(!$this->users->contains($user))
        {
            $this->users->add($user);
        }
    }

    public function removeUser(User $user)
    {
        if($this->users->contains($user))
        {
            $this->users->remove($user);
        }
    }
}
