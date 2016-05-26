<?php
/**
 * Created by PhpStorm.
 * User: Pavlik
 * Date: 2016-03-18
 * Time: 23:56
 */

namespace Users\Controller;

use Zend\Console\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\UsersForm;
use Users\Users\Model\Users;
use Zend\View\Model\JsonModel;
use Zend\Crypt\Password\Bcrypt;

class UsersController extends AbstractActionController
{
    protected $adminUserTable;

    public function indexAction()
    {
        $state = $this->zfcUserAuthentication()->getIdentity()->getCategoryId();
        if($state == 1){
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
        }else{
            return $this->redirect()->toRoute('dashboard');
        }
    }
     public function addAction(){
         $state = $this->zfcUserAuthentication()->getIdentity()->getCategoryId();
         if($state == 1){
             $form = new UsersForm();
             $groups = $this->getAdminsUsersTable()->getAllGroups();
             $form->get('groupID')->setAttribute('options', $groups);
             $view = new ViewModel(array('form' => $form));
             return $view;
         }else{
            return $this->redirect()->toRoute('dashboard');
         }
     }
    public function editAction(){
        $state = $this->zfcUserAuthentication()->getIdentity()->getCategoryId();
        if($state == 1){
            $user_id = (int) $this->params()->fromRoute('user_id', 0);
            $user = $this->getAdminsUsersTable()->getUser($user_id);
            $user_modal = new Users();
            $arr = array();
            if($user['category_id'] == 3){
                $student = $this->getAdminsUsersTable()->getStudent($user['user_id']);
                $arr = array_merge($user,$student[0]);
            }else if($user['category_id'] == 2){
                $professor = $this->getAdminsUsersTable()->getProffesor($user['user_id']);
                $arr = array_merge($user,$professor[0]);
            }else{
                $arr = $user;
            }
            $user_modal->exchangeArray($arr);
            $form = new UsersForm();
            $groups = $this->getAdminsUsersTable()->getAllGroups();
            $form->get('groupID')->setAttribute('options', $groups);
            $form->bind($user_modal);
            if($user['category_id'] == 3){
                $form->get('firstNameStudent')->setValue($student[0]['firstName']);
                $form->get('lastNameStudent')->setValue($student[0]['lastName']);
            }else if($user['category_id'] == 2){
                $form->get('firstNameProfessor')->setValue($professor[0]['firstName']);
                $form->get('lastNameProfessor')->setValue($professor[0]['lastName']);
            }
            $view = new ViewModel(array('form' => $form));
            return $view;
        }else{
            return $this->redirect()->toRoute('dashboard');
        }
    }
    public function saveeditedAction(){
        $postArray = $this->getRequest()->getPost();
        $eddited = $this->getAdminsUsersTable()->saveEditedUser($postArray);
        if($eddited){
            $result = new JsonModel(array(
                'some_parameter' => 'some value',
                'success'=>true,
            ));
        }else{
            $result = new JsonModel(array(
                'some_parameter' => 'some value',
                'success'=>false,
            ));
        }
        return $result;
    }

    public function deleteAction(){
        $state = $this->zfcUserAuthentication()->getIdentity()->getCategoryId();
        if($state == 1){
            $postArray = $this->getRequest()->getPost();
            $user_id = $postArray['user_id'];
            $this->getAdminsUsersTable()->deleteUser($user_id);
            $result = new JsonModel(array(
                'some_parameter' => 'some value',
                'success'=>true,
            ));
            return $result;
        }else{
            return $this->redirect()->toRoute('dashboard');
        }
    }

    public function saveAction(){
        $postArray = $this->getRequest()->getPost();
        $bcrypt = new Bcrypt;
        $bcrypt->setCost(14);
        $postArray['password'] = $bcrypt->create($postArray['password']);
        $added = $this->getAdminsUsersTable()->saveUser($postArray);
        if($added){
            $result = new JsonModel(array(
                'some_parameter' => 'some value',
                'success'=>true,
            ));
        }else{
            $result = new JsonModel(array(
                'some_parameter' => 'some value',
                'success'=>false,
            ));
        }
        return $result;
    }

    public function getAdminsUsersTable()
    {
        if (!$this->adminUserTable) {
            $sm = $this->getServiceLocator();
            $this->adminUserTable = $sm->get('Users\Users\Model\UsersTable');
        }
        return $this->adminUserTable;
    }
}