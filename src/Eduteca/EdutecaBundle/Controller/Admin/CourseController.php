<?php

namespace Eduteca\EdutecaBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduteca\EdutecaBundle\Entity\Course;
use Eduteca\EdutecaBundle\Entity\Content;
use Eduteca\EdutecaBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends Controller
{
    private $CLASS_NAME = 'Admin:CourseController:';
    
    public function courseListAction(Request $request)
    {
        $start  = $request->query->get('start');
        $limit  = $request->query->get('limit');
        $filter = $request->query->get('filter');
        $courseService = $this->get('courseService');
        $logger = $this->get('service.logger');
        
        try
        {
            $course = new Course();
            
            if ($filter != null)
            {
                $filter = json_decode($filter, true);
                $course->setCourseName($filter[0]['value']);
            }

            $courseList = $courseService->findCourse($course,$start,$limit,false);

            $returnValues = array();
            $returnValues['totalCount'] = $courseService->findCourseCount($course, false);

            $courseArray = array();
            for($i=0; (($i < $limit) && ($i < count($courseList))); $i=$i+1)
            {
                $contentArray = array();
                $contentArrayTmp = $courseList[$i]->getContentList();
                for($j=0; $j<count($contentArrayTmp);$j=$j+1)
                {
                    $contentArray[$j] = array(
                        'contentId'   => $contentArrayTmp[$j]->getContentId(),
                        'title'       => $contentArrayTmp[$j]->getTitle(),
                        'description' => $contentArrayTmp[$j]->getDescription(),
                        'path'        => $contentArrayTmp[$j]->getPath(),
                        'published'   => $contentArrayTmp[$j]->getPublished(),
                        'date'        => $contentArrayTmp[$j]->getDate()->format('d-m-Y H:i:s')
                    );
                }
                
                $courseArray[$i] = array(
                    'courseId'   => $courseList[$i]->getCourseId(), 
                    'courseName' => $courseList[$i]->getCourseName(),
                    'contents'   => $contentArray);
            }

            $returnValues['courses'] = $courseArray;
        }
        catch(\Exception $exception)
        {
            $logger->err('Error in '.$this->CLASS_NAME.'courseListAction: '.$exception->getMessage());
            $returnValues = array();
            $returnValues['success']  = false;
            $returnValues['message']  = $exception->getMessage();
        }

        $response = new Response(json_encode($returnValues));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    public function courseAction(Request $request, $courseId)
    {
        $returnValues = array();
        $courseService = $this->get('courseService');
        $logger = $this->get('service.logger');
        
        try
        {
            if ($request->getMethod() == 'GET')
            { 
                
            }
            else if ($request->getMethod() == 'POST')
            {
                // new course
                $data = json_decode($this->getRequest()->getContent(), true);
                $newCourse = new Course();
                $newCourse->setCourseName($data['courseName']);

                $courseList = $courseService->findCourse($newCourse,0,1,true);
                if ($courseList == null)
                {
                    $courseService->saveCourse($newCourse);
                    $returnValues['success']  = true;
                    $returnValues['courseId']  = $newCourse->getCourseId();
                    $returnValues['courseName']  = $newCourse->getCourseName();
                }
                else
                {
                    $returnValues['success']  = false;
                    $returnValues['message']  = $this->get('translator')->trans('admin.error.duplicate.course %courseName%', array('%courseName%' => $newCourse->getCourseName()));
                }
            }
            else if ($request->getMethod() == 'PUT')
            {
                // update course
                $data = json_decode($this->getRequest()->getContent(), true);
                $updateCourse = new Course();
                $updateCourse->setCourseName($data['courseName']);
                $courseList = $courseService->findCourse($updateCourse,0,1,true);
                
                if (($courseList == null) || ($courseList[0]->getCourseId() == $data['courseId']))
                {
                    $updateCourse = new Course();
                    $updateCourse->setCourseId($data['courseId']);
                    $courseList = $courseService->findCourse($updateCourse);
                    $courseList[0]->setCourseName($data['courseName']);
                    $courseService->saveCourse($courseList[0]);
                    $returnValues['success']  = true;
                }
                else
                {
                    $returnValues['success']  = false;
                    $returnValues['message']  = $this->get('translator')->trans('admin.error.duplicate.course %courseName%', array('%courseName%' => $updateCourse->getCourseName()));
                }
            }
            else if ($request->getMethod() == 'DELETE')
            {
                // delete course
                $deleteCourse = new Course();
                $deleteCourse->setCourseId($courseId);
                $courseList = $courseService->findCourse($deleteCourse);
                $courseService->deleteCourse($courseList[0]);
                $returnValues['success']  = true;
            }
        }
        catch(\Exception $exception)
        {
            $logger->err('Error in '.$this->CLASS_NAME.'courseAction: '.$exception->getMessage());
            $returnValues = array();
            $returnValues['success']  = false;
            $returnValues['message']  = $exception->getMessage();
        }
        
        $response = new Response(json_encode($returnValues));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}
