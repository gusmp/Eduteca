<?php

namespace Eduteca\EdutecaBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduteca\EdutecaBundle\Entity\Course;
use Eduteca\EdutecaBundle\Entity\Content;
use Eduteca\EdutecaBundle\Entity\User;
use Eduteca\EdutecaBundle\Entity\DateRange;
use Symfony\Component\HttpFoundation\Response;

class ContentController extends Controller
{
    private $CLASS_NAME = 'Admin:ContentController:';
    
    public function contentListAction(Request $request)
    {
        $start  = $request->query->get('start');
        $limit  = $request->query->get('limit');
        $filter = $request->query->get('filter');
        $contentService = $this->get('contentService');
        $logger = $this->get('service.logger');
        
        try
        {
            $content = new Content();
            $contentDateRange = new DateRange();
            
            if ($filter != null)
            {
                $filter = json_decode($filter, true);

                for($i=0; $i < count($filter); $i=$i+1)
                {
                    switch($filter[$i]['property'])
                    {
                        case 'title':
                            $content->setTitle($filter[$i]['value']);
                        break;
                        case 'description':
                            $content->setDescription($filter[$i]['value']);
                        break;
                        case 'startDate':
                            $contentDateRange->setStartDate($filter[$i]['value']);
                        break;                    
                        case 'endDate':
                            $endDate = \DateTime::createFromFormat('Y-m-d\TH:i:s', $filter[$i]['value']);
                            $endDate->setTime(23,59,59);
                            $contentDateRange->setEndDate($endDate);
                        break;    
                        case 'published':
                            $content->setPublished(true);
                        break;
                        case 'courseId':
                            $content->getCourse()->setCourseId($filter[$i]['value']);
                        break;
                        case 'userId':
                            $content->getUser()->setUserId($filter[$i]['value']);
                        break;
                    }
                }
            }
            
            $contentList = $contentService->findContent($content,$start,$limit,false, $contentDateRange);

            $returnValues = array();
            $returnValues['totalCount'] = $contentService->findContentCount($content, false, $contentDateRange);

            $contentArray = array();
            for($i=0; (($i < $limit) && ($i < count($contentList))); $i=$i+1)
            {
                $contentArray[$i] = array(
                    'contentId' => $contentList[$i]->getContentId(),
                    'title'        => $contentList[$i]->getTitle(),
                    'description'  => $contentList[$i]->getDescription(),
                    'path'         => $contentList[$i]->getPath(),
                    'published'    => $contentList[$i]->getPublished(),
                    'date'         => $contentList[$i]->getDate()->format('d-m-Y H:i:s'),
                    'courses'      => array('courseId' => $contentList[$i]->getCourse()->getCourseId(),
                                              'courseName' => $contentList[$i]->getCourse()->getCourseName()
                                      ),
                    'users'       =>  array('userId' => $contentList[$i]->getUser()->getUserId(),
                                            'login'  => $contentList[$i]->getUser()->getLogin(),
                                            'password'  => $contentList[$i]->getUser()->getPassword(),
                                            'name'      => $contentList[$i]->getUser()->getName(),
                                            'surname1'  => $contentList[$i]->getUser()->getSurname1(),
                                            'surname2'  => $contentList[$i]->getUser()->getSurname2(),
                                            'approved'  => $contentList[$i]->getUser()->getApproved(),
                                            'email'     => $contentList[$i]->getUser()->getEmail()
                                      )
                );
            }

            $returnValues['contents'] = $contentArray;
        }
        catch(\Exception $exception)
        {
            $logger->err('Error in '.$this->CLASS_NAME.'contentListAction: '.$exception->getMessage());
            $returnValues = array();
            $returnValues['success']  = false;
            $returnValues['message']  = $exception->getMessage();
        }

        $response = new Response(json_encode($returnValues));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    public function contentAddAction(Request $request)
    {
        $logger = $this->get('service.logger');
        $contentService = $this->get('contentService');
        $courseService = $this->get('courseService');
        $returnValues = array();
        
        try
        {
            $content = new Content();
            $content->setTitle($request->request->get('title'));
            
            $contentList = $contentService->findContent($content);
            if ($contentList == null)
            {
                $content->setDescription($request->request->get('description'));
                $content->setDate(new \DateTime("now"));
                $content->setFile($this->get('request')->files->get('path'));

                if ($request->request->get('published') == 'on')
                {
                    $content->setPublished(true);
                }
                else
                {
                    $content->setPublished(false);
                }

                $content->upload();

                $course = new Course();
                $course->setCourseId($request->request->get('courseId'));
                $courseList = $courseService->findCourse($course);
                $content->setCourse($courseList[0]);

                $user = $this->get('security.context')->getToken()->getUser();
                $content->setUser($user);

                $contentService->saveContent($content);

                $returnValues['success']  = true;
                $returnValues['message']  = $content->getTitle();
            }
            else
            {
                $returnValues['success']  = false;
                $returnValues['message']  = $this->get('translator')->trans('admin.error.duplicate.content %title%', array('%title%' => $content->getTitle()));
            }
        }
        catch(\Exception $exception)
        {
            $logger->err('Error in '.$this->CLASS_NAME.'contentAddAction: '.$exception->getMessage());
            $returnValues['success']  = false;
            $returnValues['message']  = $exception->getMessage();
        }
        
        $response = new Response(json_encode($returnValues));
        $response->headers->set('Content-Type', 'text/html');
        
        return $response;
    }
    
    public function contentUpdateAction(Request $request)
    {
        $logger = $this->get('service.logger');
        $contentService = $this->get('contentService');
        $courseService = $this->get('courseService');
        $userService = $this->get('userService');
        $returnValues = array();
        
        try
        {
            $content = new Content();
            $content->setContentId($request->request->get('contentId'));
            
            $contentList = $contentService->findContent($content);
            if ($contentList != null)
            {
                $contentList[0]->setTitle($request->request->get('title'));
                $contentList[0]->setDescription($request->request->get('description'));

                $oldFile = null;
                if ($this->get('request')->files->get('path') != '')
                {
                    $oldFile = $contentList[0]->getAbsolutePath();
                    $contentList[0]->setFile($this->get('request')->files->get('path'));
                    $contentList[0]->upload();
                }

                if ($request->request->get('published') == 'on')
                {
                    $contentList[0]->setPublished(true);
                }
                else
                {
                    $contentList[0]->setPublished(false);
                }

                
                if ($contentList[0]->getCourse()->getCourseId() != $request->request->get('courseId'))
                {
                    $course = new Course();
                    $course->setCourseId($request->request->get('courseId'));
                    $courseList = $courseService->findCourse($course);
                    $contentList[0]->setCourse($courseList[0]);
                }
                
                if ($contentList[0]->getUser()->getUserId() != $request->request->get('userId'))
                {
                    $user = new User();
                    $user->setUserId($request->request->get('userId'));
                    $userList = $userService->findUser($user);
                    $contentList[0]->setUser($userList[0]);
                }

                
                $contentService->updateContent($contentList[0], $oldFile);

                $returnValues['success']  = true;
                $returnValues['message']  = $contentList[0]->getTitle();
            }
            else
            {
                $returnValues['success']  = false;
                $returnValues['message']  = $this->get('translator')->trans('admin.error.duplicate.content %title%', array('%title%' => $content->getTitle()));
            }
           
        }
        catch(\Exception $exception)
        {
            $logger->err('Error in '.$this->CLASS_NAME.'contentUpdatetAction: '.$exception->getMessage());
            $returnValues['success']  = false;
            $returnValues['message']  = $exception->getMessage();
        }
        
        $response = new Response(json_encode($returnValues));
        $response->headers->set('Content-Type', 'text/html');
        
        return $response;
    }
    
    public function contentDeleteAction(Request $request, $contentId)
    {
        $returnValues = array();
        $contentService = $this->get('contentService');
        $logger = $this->get('service.logger');
        
        try
        {
            if ($request->getMethod() == 'GET'){ }
            else if ($request->getMethod() == 'POST') { }
            else if ($request->getMethod() == 'PUT') { }
            else if ($request->getMethod() == 'DELETE')
            {
                // delete content
                $deleteContent = new Content();
                $deleteContent->setContentId($contentId);
                $contentList = $contentService->findContent($deleteContent);
                $contentService->deleteContent($contentList[0]);
                $returnValues['success']  = true;
            }
        }
        catch(\Exception $exception)
        {
            $logger->err('Error in '.$this->CLASS_NAME.'contentDeleteAction: '.$exception->getMessage());
            $returnValues = array();
            $returnValues['success']  = false;
            $returnValues['message']  = $exception->getMessage();
        }
        
        $response = new Response(json_encode($returnValues));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    public function contentDownloadAction($contentId)
    {
        $contentService = $this->get('contentService');
        $contentList = $contentService->findContent(Content::constructWithId($contentId));
        
        $headers = array(
            'Content-Type' => $contentList[0]->getMimeType(),
            'Content-Disposition' => 'attachment; filename="'.$contentList[0]->getPath().'"'
        ); 
        
        return new Response(file_get_contents($contentList[0]->getAbsolutePath()), 200, $headers);
    }
}
