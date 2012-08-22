<?php

namespace Eduteca\EdutecaBundle\Service\impl;

use Eduteca\EdutecaBundle\Repository\GroupRepository;
use Eduteca\EdutecaBundle\Entity\Group;
use Eduteca\EdutecaBundle\Service\GroupService;

class GroupServiceImpl implements GroupService
{
    private $groupRepository;
    
    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }
            
    public function saveGroup(Group $group)
    {
        $this->groupRepository->saveGroup($group);
    }
    
    public function findGroup(Group $group)
    {
        return $this->groupRepository->findGroup($group);
    }
    
    public function findGroupArray(Group $group)
    {
        $groupArray = array();
        $groupList = $this->groupRepository->findGroup($group);
        foreach ($groupList as $index => $group) 
        {
            $groupArray[$group->getGroupId()] = $group->getGroupName();
        }
        
        return $groupArray;
    }
    
    public function deleteGroup(Group $group)
    {
        return $this->groupRepository->deleteGroup($group);
    }
}

?>
