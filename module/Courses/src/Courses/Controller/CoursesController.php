<?php
/**
 * Created by PhpStorm.
 * User: Pavlik
 * Date: 2016-03-18
 * Time: 23:56
 */

namespace Courses\Controller;

use Zend\Console\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Courses\Form\CoursesForm;
use Courses\Courses\Model\Courses;
use Zend\View\Model\JsonModel;
use Zend\Crypt\Password\Bcrypt;

class CoursesController extends AbstractActionController
{
    protected $coursesTable;

    public function indexAction()
    {
            $info = "";
            $state = "";
            if($this->zfcUserAuthentication()->hasIdentity()){
                $state = $this->zfcUserAuthentication()->getIdentity()->getCategoryId();
                if($state == 1){
                    $info = $this->getCoursesTable()->fetchAllSelect();
                }else if($state == 2){
                    $info = $this->getCoursesTable()->getAllProfessorCourses($this->zfcUserAuthentication()->getIdentity()->getId());
                }else if ($state == 3){
                    $info = $this->getCoursesTable()->getAllDisciplines($this->zfcUserAuthentication()->getIdentity()->getId());
                }
            }
            $view = new ViewModel(array('info' => $info,'state' => $state));
            return $view;
    }
     
    public function getCoursesTable()
    {
        if (!$this->coursesTable) {
            $sm = $this->getServiceLocator();
            $this->coursesTable = $sm->get('Courses\Courses\Model\CoursesTable');
        }
        return $this->coursesTable;
    }
}