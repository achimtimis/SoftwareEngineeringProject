<?php
/**
 * Created by PhpStorm.
 * User: Pavlik
 * Date: 2016-03-18
 * Time: 23:56
 */

namespace Dashboard\Controller;

use Zend\Console\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Dashboard\Form\DashboardForm;
use Dashboard\Dashboard\Model\Dashboard;
use Zend\View\Model\JsonModel;

class DashboardController extends AbstractActionController
{
    protected $adminUserTable;

    public function indexAction()
    {
        $info = "";
        $state = "";
        if($this->zfcUserAuthentication()->hasIdentity()){
            $state = $this->zfcUserAuthentication()->getIdentity()->getCategoryId();
            if($state == 1){
                $info = $this->getAdminsUsersTable()->fetchAllSelect();
            }else if($state == 2){
                $info = $this->getAdminsUsersTable()->getAllProfessorCourses($this->zfcUserAuthentication()->getIdentity()->getId());
            }else if ($state == 3){
                $info = $this->getAdminsUsersTable()->getAllDisciplines($this->zfcUserAuthentication()->getIdentity()->getId());
            }
        }
        $view = new ViewModel(array('info' => $info,'state' => $state));
        return $view;
    }
     public function addAction(){
         $form = new DashboardForm();
         $view = new ViewModel(array('form' => $form));
         return $view;
     }

    public function getAdminsUsersTable()
    {
        if (!$this->adminUserTable) {
            $sm = $this->getServiceLocator();
            $this->adminUserTable = $sm->get('Users\Users\Model\DashboardTable');
        }
        return $this->adminUserTable;
    }
}