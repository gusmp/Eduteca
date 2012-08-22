<?php

namespace Eduteca\EdutecaBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduteca\EdutecaBundle\Entity\Group;
use Symfony\Component\HttpFoundation\Response;

class GroupController extends Controller
{
    private $CLASS_NAME = 'Admin:GroupController:';
    
    public function groupListAction(Request $request)
    {
        $groupService = $this->get('groupService');
        $logger = $this->get('service.logger');
        
        try
        {
            $groupList = $groupService->findGroup(new Group());
            
            $returnValues = array();
            $returnValues['totalCount'] = count($groupList);

            $groupArray = array();
            for($i=0; $i < count($groupList); $i=$i+1)
            {
                $groupArray[$i] = array(
                    'groupId'   => $groupList[$i]->getGroupId(), 
                    'groupName' => $groupList[$i]->getGroupName());
            }

            $returnValues['groups'] = $groupArray;
        }
        catch(\Exception $exception)
        {
            $logger->err('Error in '.$this->CLASS_NAME.'groupListAction: '.$exception->getMessage());
            $returnValues = array();
            $returnValues['success']  = false;
            $returnValues['message']  = $exception->getMessage();
        }

        $response = new Response(json_encode($returnValues));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    

}
