<?php

namespace Eduteca\EdutecaBundle\Service\impl;

use Eduteca\EdutecaBundle\Repository\UserRepository;
use Eduteca\EdutecaBundle\Entity\User;
use Eduteca\EdutecaBundle\Entity\Group;
use Eduteca\EdutecaBundle\Service\UserService;
use Eduteca\EdutecaBundle\Service\GroupService;

class UserServiceImpl implements UserService
{
    private $userRepository;
    private $groupService;
    
    public function __construct(UserRepository $userRepository, GroupService $groupService)
    {
        $this->userRepository = $userRepository;
        $this->groupService = $groupService;
    }
    

    public function saveUser(User $user)
    {
        if ($user->getApproved() == null)
        {
            $user->setApproved(false);
        }
        
        if ($user->getGroupList()->count() == 0)
        {
            $g = new Group();
            $g->setRole(GroupService::ROLE_USERS);
            $groupList = $this->groupService->findGroup($g);
            $user->getGroupList()->add($groupList[0]);
            $groupList[0]->getUserList()->add($user);
        }
        
        $this->userRepository->saveUser($user,true);
    }
    
    public function updateUser(User $user, $newPassword)
    {
        if ($user->getPassword() != $newPassword)
        {
            $user->setPassword($newPassword);
            $this->userRepository->saveUser($user, true);
        }
        else
        {
            $this->userRepository->saveUser($user, false);
        }
    }
    
    public function findUserCount(User $user, $strictLogin)
    {
        return $this->userRepository->findUserCount($user, $strictLogin);
    }
    
    public function findUser(User $user, $start=0, $limit=0, $strictLogin=false)
    {
        return $this->userRepository->findUser($user, $start, $limit, $strictLogin);
    }
     
    public function deleteUser(User $user)
    {
        $this->userRepository->deleteUser($user);
    }
    
    private function addGroup($groupName,$groupRole)
    {
        $newGroup = new Group();
        $newGroup->setRole($groupRole);
        $newGroup = $this->groupService->findGroup($newGroup);
        if ($newGroup == null)
        {
            $newGroup = new Group();
            $newGroup->setGroupName($groupName);
            $newGroup->setRole($groupRole);
            $this->groupService->saveGroup($newGroup);
        }
        else
        {
            $newGroup = $newGroup[0];   
        }
        return $newGroup;
    }
    
    public function enableAdminUser()
    {
        $user = new User();
        $user->setLogin('admin');
        
        $admin = $this->userRepository->findUser($user,0,1,true);
        if ($admin == null)
        {
            $this->addGroup('Usuarios' ,GroupService::ROLE_USERS);
            $groupAdmin = $this->addGroup('Administradores' ,GroupService::ROLE_ADMIN);
            
            $user->setLogin('admin');
            $user->setPassword('admin');
            $user->setName('admin');
            $user->setSurname1('admin');
            $user->setSurname2('admin');
            $user->setApproved(true);
            $user->setEmail('admin@admin.com');
            $user->getGroupList()->add($groupAdmin);
            $this->userRepository->saveUser($user, true);
        }
    }
}

?>
