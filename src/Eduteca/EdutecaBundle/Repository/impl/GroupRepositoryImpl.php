<?php

namespace Eduteca\EdutecaBundle\Repository\impl;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Monolog\Logger;
use Eduteca\EdutecaBundle\Entity\Group;
use Eduteca\EdutecaBundle\Repository\GroupRepository;
use Eduteca\EdutecaBundle\Repository\impl\BaseRepository;
use Eduteca\EdutecaBundle\Repository\impl\CriteriaOption;

class GroupRepositoryImpl extends BaseRepository implements GroupRepository
{
    private $em;
    private $logger;
    
    public function __construct(EntityManager $em, Logger $logger)
    { 
        $this->em = $em;
        $this->logger = $logger;
    }
            
    public function saveGroup(Group $group)
    {
        $this->em->persist($group);
        $this->em->flush();
    }
    
    public function findGroup(Group $group)
    {
        $qb = $this->em->createQueryBuilder();
        
        $qb->add('select', 'g');
        $qb->add('from', 'EdutecaBundle:Group g');
        
        $qb = $this->addConstrain($qb, $group->getGroupId(), 'g.groupId','groupId', CriteriaOption::EQUAL);
        $qb = $this->addConstrain($qb, $group->getGroupName(), 'g.groupName','groupName', CriteriaOption::LIKE);
        $qb = $this->addConstrain($qb, $group->getRole(), 'g.role','role', CriteriaOption::EQUAL);
        
        $qb->add('orderBy', 'g.groupName ASC');
        
        $query = $qb->getQuery();
        return $query->getResult();
    }
    
    public function deleteGroup(Group $group)
    {
        $this->em->remove($group);
        $this->em->flush();
    }
}

?>
