<?php

namespace Eduteca\EdutecaBundle\Controller\MobileWeb;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduteca\EdutecaBundle\Entity\Course;
use Eduteca\EdutecaBundle\Entity\Content;
use Eduteca\EdutecaBundle\Entity\User;
use Eduteca\EdutecaBundle\Entity\DateRange;


class MobileWebController extends Controller
{
    
    private $CLASS_NAME = 'MobileWeb:MobileWebController:';
    
    public function mobileWebAction()
    {
        return $this->render('EdutecaBundle:MobileWeb:index.html.twig');
    }
    
    public function mobileWebUserAction(Request $request, $userId=0)
    {
        $returnValues = array();
        $userService = $this->get('userService');
        $logger = $this->get('service.logger');
        
        try
        {
            if ($request->getMethod() == 'POST')
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
    
    public function mobileWebCourseListAction(Request $request)
    {
        $courseService = $this->get('courseService');
        $logger = $this->get('service.logger');
        
        try
        {
            $course = new Course();
            $courseList = $courseService->findCourse($course,0,0,false);

            $returnValues = array();
            $returnValues['totalCount'] = $courseService->findCourseCount($course, false);

            $courseArray = array();
            for($i=0; $i < count($courseList); $i=$i+1)
            {
                $courseArray[$i] = array(
                    'courseId'   => $courseList[$i]->getCourseId(), 
                    'courseName' => $courseList[$i]->getCourseName());
            }

            $returnValues['courses'] = $courseArray;
        }
        catch(\Exception $exception)
        {
            $logger->err('Error in '.$this->CLASS_NAME.'mobileWebCourseListAction: '.$exception->getMessage());
            $returnValues = array();
            $returnValues['success']  = false;
            $returnValues['message']  = $exception->getMessage();
        }

        $response = new Response(json_encode($returnValues));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    
    public function mobileWebContentListAction(Request $request)
    {
        $contentService = $this->get('contentService');
        $logger = $this->get('service.logger');
        
        $courseIdFilter = $request->query->get('courseId');
        $titleFilter = $request->query->get('title');
        $descriptionFilter = $request->query->get('description');
        
        
        try
        {
            $content = new Content();
            $contentDateRange = new DateRange();

            if ($courseIdFilter != null)
            {
                $content->getCourse()->setCourseId($courseIdFilter);
            }
            if ($titleFilter != null)
            {
                $content->setTitle($titleFilter);
            }
            if ($descriptionFilter != null)
            {
                $content->setDescription($descriptionFilter);
            }
            
            
            $content->setPublished(true);
            $contentList = $contentService->findContent($content,$start,$limit,false, $contentDateRange);

            $returnValues = array();
            $returnValues['totalCount'] = $contentService->findContentCount($content, false, $contentDateRange);

            $contentArray = array();
            for($i=0;  $i < count($contentList); $i=$i+1)
            {
                $contentArray[$i] = array(
                    'contentId' => $contentList[$i]->getContentId(),
                    'title'        => $contentList[$i]->getTitle(),
                    'description'  => $contentList[$i]->getDescription(),
                    'path'         => $contentList[$i]->getPath(),
                    'published'    => $contentList[$i]->getPublished(),
                    'date'         => $contentList[$i]->getDate()->format('d-m-Y H:i:s'));
            }

            $returnValues['contents'] = $contentArray;
        }
        catch(\Exception $exception)
        {
            $logger->err('Error in '.$this->CLASS_NAME.'mobileWebContentListAction: '.$exception->getMessage());
            $returnValues = array();
            $returnValues['success']  = false;
            $returnValues['message']  = $exception->getMessage();
        }

        $response = new Response(json_encode($returnValues));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
