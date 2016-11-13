<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use AppBundle\Entity\User;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    /**
     * @return User
     */
    public function findUserByUsername($username)
    {
        return $this->findOneBy(['username' => $username]);
    }

    /**
     * @return User
     */
    public function findUserByEmail($email)
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function loadUserByUsername($username)
    {
        $user = $this->findUserByUsername($username);

        // or by email..
        if (!$user) $user = $this->findUserByEmail($username);
        if (!$user) throw new UsernameNotFoundException(sprintf('Invalide Eingabe', $username));

        return $user;
    }
}
