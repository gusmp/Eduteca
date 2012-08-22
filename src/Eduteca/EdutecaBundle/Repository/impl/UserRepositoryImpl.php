<?php

namespace Eduteca\EdutecaBundle\Repository\impl;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Eduteca\EdutecaBundle\Entity\User;
use Eduteca\EdutecaBundle\Repository\UserRepository;
use Eduteca\EdutecaBundle\Repository\impl\BaseRepository;
use Eduteca\EdutecaBundle\Repository\impl\CriteriaOption;

class UserRepositoryImpl extends BaseRepository implements UserRepository
{
    private $em;
    private $logger;
    private $securityEncoderFactory;
    
    public function __construct(EntityManager $em, Logger $logger,EncoderFactory $securityEncoderFactory)
    { 
        $this->em = $em;
        $this->logger = $logger;
        $this->securityEncoderFactory = $securityEncoderFactory;
    }
            
    public function saveUser(User $user, $encodePassword)
    {
        if ($encodePassword == true)
        {
            $encoder = $this->securityEncoderFactory->getEncoder($user);
            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);
        }

        $this->em->persist($user);
        $this->em->flush();
    }
    
    private function buildFindUserQuery(User $user,$strictLogin)
    {
        $qb = $this->em->createQueryBuilder();
        
        $qb->add('select', 'u');
        $qb->add('from', 'EdutecaBundle:User u');
        
        $qb = $this->addConstrain($qb, $user->getUserId(), 'u.userId','userId', CriteriaOption::EQUAL);
        if ($strictLogin == true)
        {
            $qb = $this->addConstrain($qb, $user->getLogin(), 'u.login','login', CriteriaOption::EQUAL);
        }
        else
        {
            $qb = $this->addConstrain($qb, $user->getLogin(), 'u.login','login', CriteriaOption::LIKE);
        }
        $qb = $this->addConstrain($qb, $user->getName(), 'u.name','name', CriteriaOption::LIKE);
        $qb = $this->addConstrain($qb, $user->getSurname1(), 'u.surname1','surname1', CriteriaOption::LIKE);
        $qb = $this->addConstrain($qb, $user->getSurname2(), 'u.surname2','surname2', CriteriaOption::LIKE);
        $qb = $this->addConstrain($qb, $user->getEmail() , 'u.email','email', CriteriaOption::LIKE);
        $qb = $this->addConstrain($qb, $user->getApproved() , 'u.approved','approved', CriteriaOption::EQUAL);
        
        return $qb;
    }
    
    public function findUserCount(User $user, $strictLogin)
    {
        $qb = $this->buildFindUserQuery($user, $strictLogin);
        $query = $qb->getQuery();
        return count($query->getResult());
    }
    
    public function findUser(User $user, $start=0, $limit=0, $strictLogin = false)
    {
        $qb = $this->buildFindUserQuery($user, $strictLogin);
        
        $qb->add('orderBy', 'u.login ASC');
        
        if ($start != 0)
        {
            $qb->setFirstResult($start);
        }
        
        if ($limit != 0)
        {
            $qb->setMaxResults($limit);
        }
        
        $query = $qb->getQuery();
        
        return $query->getResult();
    }
    
    public function deleteUser(User $user)
    {
        $this->em->remove($user);
        $this->em->flush();
    }
}


?>
