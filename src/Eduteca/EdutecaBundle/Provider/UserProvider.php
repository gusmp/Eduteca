<?php

namespace Eduteca\EdutecaBundle\Provider;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Eduteca\EdutecaBundle\Repository\UserRepository;
use Eduteca\EdutecaBundle\Entity\User;

class UserProvider extends EntityRepository implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
        $query = $this
            ->createQueryBuilder('u')
            ->select('u, g')
            ->leftJoin('u.groupList', 'g')
            ->where('u.login = :username')
            ->andWhere('u.approved = :approved')
            ->setParameter('username', $username)
            ->setParameter('approved', true)
            ->getQuery();
        
        try
        {
            $user = $query->getSingleResult();
        }
        catch(NoResultException $e)
        {
            throw new UsernameNotFoundException(sprintf('Usuario no encontrado'), null, 0, $e);
        }

        return $user;
    }
    
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class))
        {
            throw new UnsupportedUserException(sprintf('%s no soportada', $class));
        }
        
        return $this->loadUserByUsername($user->getUsername());
    }
    
    public function supportsClass($class)
    {
        return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
    }
            
}

?>
