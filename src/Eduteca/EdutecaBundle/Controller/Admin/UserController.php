<?php

namespace Eduteca\EdutecaBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduteca\EdutecaBundle\Entity\User;
use Eduteca\EdutecaBundle\Entity\Group;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;

class UserController extends Controller
{
    private $CLASS_NAME = 'Admin:UserController:';
    
    public function userListAction(Request $request)
    {
        $start  = $request->query->get('start');
        $limit  = $request->query->get('limit');
        $filter = $request->query->get('filter');
        $userService = $this->get('userService');
        $logger = $this->get('service.logger');
        
        try
        {
            $user = new User();

            if ($filter != null)
            {
                $filter = json_decode($filter, true);

                for($i=0; $i < count($filter); $i=$i+1)
                {
                    switch($filter[$i]['property'])
                    {
                        case 'login':
                            $user->setLogin($filter[$i]['value']);
                        break;
                        case 'name':
                            $user->setName($filter[$i]['value']);
                        break;
                        case 'surname1':
                            $user->setSurname1($filter[$i]['value']);
                        break;
                        case 'surname2':
                            $user->setSurname2($filter[$i]['value']);
                        break;
                        case 'approved':
                            $user->setApproved($filter[$i]['value']);
                        break;
                        case 'email':
                            $user->setEmail($filter[$i]['value']);
                        break;
                    }
                }
            }

            $userList = $userService->findUser($user,$start,$limit,false);

            $returnValues = array();
            $returnValues['totalCount'] = $userService->findUserCount($user, false);

            $userArray = array();
            for($i=0; (($i < $limit) && ($i < count($userList))); $i=$i+1)
            {
                $groupList = $userList[$i]->getGroupList();
                
                $userArray[$i] = array(
                    'userId'   => $userList[$i]->getUserId(), 
                    'login'    => $userList[$i]->getLogin(),
                    'password' => $userList[$i]->getPassword(),
                    'name'     => $userList[$i]->getName(),
                    'surname1' => $userList[$i]->getSurname1(),
                    'surname2' => $userList[$i]->getSurname2(),
                    'approved' => $userList[$i]->getApproved(),
                    'email'    => $userList[$i]->getEmail(),
                    'groups'   => array('groupId' =>  $groupList[0]->getGroupId(),
                                        'groupName' => $groupList[0]->getGroupName()
                                    )
                );
            }

            $returnValues['users'] = $userArray;
        }
        catch(\Exception $exception)
        {
            $logger->err('Error in '.$this->CLASS_NAME.'userListAction: '.$exception->getMessage());
            $returnValues = array();
            $returnValues['success']  = false;
            $returnValues['message']  = $exception->getMessage();
        }

        $response = new Response(json_encode($returnValues));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    public function userAction(Request $request, $userId)
    {
        $returnValues = array();
        $userService = $this->get('userService');
        $groupService = $this->get('groupService');
        $logger = $this->get('service.logger');        
        
        try
        {
            if ($request->getMethod() == 'GET')
            { 
                
            }
            else if ($request->getMethod() == 'POST')
            {
                // new user
                $data = json_decode($this->getRequest()->getContent(), true);

                $newUser = new User();
                $newUser->setLogin($data['login']);

                $userList = $userService->findUser($newUser,0,1,true);
                
                if ($userList == null)
                {
                    $newUser->setLogin($data['login']);
                    $newUser->setPassword($data['password']);
                    $newUser->setName($data['name']);
                    $newUser->setSurname1($data['surname1']);
                    $newUser->setSurname2($data['surname2']);
                    $newUser->setEmail($data['email']);
                    $newUser->setApproved($data['approved']);
                    
                    $group = new Group();
                    $group->setGroupId($data['groupId']);
                    $groupList = $groupService->findGroup($group);
                    $newUser->getGroupList()->add($groupList[0]);

                    $userService->saveUser($newUser);
                    $returnValues['success']  = true;
                    $returnValues['userId']  = $newUser->getUserId();
                    $returnValues['login']  = $newUser->getLogin();
                }
                else
                {
                    $returnValues['success']  = false;
                    $returnValues['message']  = $this->get('translator')->trans('admin.error.duplicate.user %login%', array('%login%' => $newUser->getLogin()));
                }
            }
            else if ($request->getMethod() == 'PUT')
            {
                // update user
                $data = json_decode($this->getRequest()->getContent(), true);
                $updateUser = new User();
                $updateUser->setLogin($data['login']);
                $userList = $userService->findUser($updateUser,0,1,true);
                
                if (($userList == null) || ($userList[0]->getUserId() == $data['userId']))
                {
                    $updateUser = new User();
                    $updateUser->setUserId($data['userId']);
                    $userList = $userService->findUser($updateUser);

                    $userList[0]->setLogin($data['login']);
                    $userList[0]->setName($data['name']);
                    $userList[0]->setSurname1($data['surname1']);
                    $userList[0]->setSurname2($data['surname2']);
                    $userList[0]->setApproved($data['approved']);
                    $userList[0]->setEmail($data['email']);
                    
                    $currentGroupList = $userList[0]->getGroupList();
                    if ($data['groupId'] != $currentGroupList[0]->getGroupId())
                    {
                        $group = new Group();
                        $group->setGroupId($data['groupId']);
                        $newGroupList = $groupService->findGroup($group);
                        $userList[0]->getGroupList()->clear();
                        $userList[0]->getGroupList()->add($newGroupList[0]);
                    }
                    
                    $userService->updateUser($userList[0], $data['password']);
                    $returnValues['success']  = true;
                }
                else
                {
                    $returnValues['success']  = false;
                    $returnValues['message']  = $this->get('translator')->trans('admin.error.duplicate.user %login%', array('%login%' => $updateUser->getLogin()));
                }
            }
            else if ($request->getMethod() == 'DELETE')
            {
                // delete user
                $deleteUser = new User();
                $deleteUser->setUserId($userId);
                $userList = $userService->findUser($deleteUser);
                $userService->deleteUser($userList[0]);
                $returnValues['success']  = true;
            }
        }
        catch(\Exception $exception)
        {
            $logger->err('Error in '.$this->CLASS_NAME.'userAction: '.$exception->getMessage());
            $returnValues = array();
            $returnValues['success']  = false;
            $returnValues['message']  = $exception->getMessage();
        }
        
        $response = new Response(json_encode($returnValues));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}
