<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */


namespace Users\Users\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;

class UsersTable extends AbstractTableGateway
{


    protected $table = 'user';
    protected $tableGateway;
    protected $studentGateway;
    protected $professorGateway;
    protected $adapter;

    public function __construct(Adapter $adapter, TableGateway $tableGateway , TableGateway $studentGateway, TableGateway $professorGateway)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Users());
        $this->tableGateway = $tableGateway;
        $this->studentGateway = $studentGateway;
        $this->professorGateway = $professorGateway;
        $this->initialize();
    }


    public function fetchAllSelect()
    {
        $sql = new Sql($this->adapter);
        $adapter = $this->adapter;
        $select = $sql->select();
        $select->from('user')
            ->columns(array('*'));
        $select->order('user_id DESC');
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $results = $results->toArray();
        return $results;
    }

    public function verifyEmail($email)
    {
        $sql = new Sql($this->adapter);
        $adapter = $this->adapter;
        $select = $sql->select();
        $select->from('user')
            ->columns(array('*'))
            ->where(array('email' => $email));
        $select->order('user_id DESC');
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $results = $results->toArray();
        if(count($results) > 0){
            return false;
        }else{
            return true;
        }
    }

    public function verifyEmailWithId($email, $user_id){
        $sql = new Sql($this->adapter);
        $adapter = $this->adapter;
        $select = $sql->select();
        $select->from('user')
            ->columns(array('*'))
            ->where(array('email' => $email));
        $select->order('user_id DESC');
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $results = $results->toArray();
        if(count($results) > 0){
            if($user_id == $results[0]['user_id']){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

    public function saveUser($user)
    {
        $data = array(
            'user_id' => $user['user_id'],
            'display_name' => $user['display_name'],
            'password' => $user['password'],
            'username' => $user['username'],
            'email' => $user['email'],
            'category_id' => $user['category_id'],
            'state' => $user['state'],
        );
        if($this->verifyEmail($user['email'])){
            $this->tableGateway->insert($data);
            $last_id = $this->tableGateway->lastInsertValue;
            if($data['category_id'] == 3){
                $dataStudent = array(
                    'user_id' => $last_id,
                    'firstName' => $user['firstNameStudent'],
                    'lastName' => $user['lastNameStudent'],
                    'groupID' => $user['groupID']
                );
                $this->studentGateway->insert($dataStudent);
            }else if($data['category_id'] == 2){
                $dataProfessor = array(
                    'user_id' => $last_id,
                    'firstName' => $user['firstNameProfessor'],
                    'lastName' => $user['lastNameProfessor'],
                    'degree' => $user['degree']
                );
                $this->professorGateway->insert($dataProfessor);
            }
            return true;
        }else{
            return false;
        }
    }

    public function saveEditedUser($user){
        $data = array(
            'user_id' => $user['user_id'],
            'display_name' => $user['display_name'],
            'username' => $user['username'],
            'email' => $user['email'],
            'category_id' => $user['category_id'],
            'state' => $user['state'],
        );
        if($this->verifyEmailWithId($user['email'], $user['user_id'])){
            $this->tableGateway->update($data, array('user_id' => $data['user_id']));
            if($data['category_id'] == 3){
                $dataStudent = array(
                    'firstName' => $user['firstNameStudent'],
                    'lastName' => $user['lastNameStudent'],
                    'groupID' => $user['groupID']
                );
                $this->studentGateway->update($dataStudent, array('studID' => $user['studID']));
            }else if($data['category_id'] == 2){
                $dataProfessor = array(
                    'firstName' => $user['firstNameProfessor'],
                    'lastName' => $user['lastNameProfessor'],
                    'degree' => $user['degree']
                );
                $this->professorGateway->update($dataProfessor, array('professorID' => $user['professorID']));
            }
            return true;
        }else{
            return false;
        }
    }

    public function getAllDisciplines($user_id)
    {
        $adapter = $this->adapter;
        $results = $adapter->query("select p.firstName, p.lastName, d.title, d.type, c.grade FROM students s 
                                    INNER JOIN Contracts c ON c.studID = s.studID 
                                    INNER JOIN Disciplines d ON d.disciplineID = c.disciplineID
                                    INNER JOIN Professors p ON p.professorID = c.professorID
                                    WHERE s.user_id = $user_id
                                     ", $adapter::QUERY_MODE_EXECUTE);
        $results = $results->toArray();
        return $results;
    }


    public function getAllGroups(){
        $adapter = $this->adapter;
        $results = $adapter->query("select * from groups", $adapter::QUERY_MODE_EXECUTE);
        $results = $results->toArray();
        $arr = array();
        for($i = 0; $i< count($results); $i++){
            $arr[$results[$i]['groupID']] = $results[$i]['groupNr'];
        }
        return $arr;
    }

    public function getStudent($user_id){
        $adapter = $this->adapter;
        $results = $adapter->query("select * from students where user_id = '$user_id'", $adapter::QUERY_MODE_EXECUTE);
        $results = $results->toArray();
        return $results;
    }

    public function getProffesor($user_id){
        $adapter = $this->adapter;
        $results = $adapter->query("select * from professors where user_id = '$user_id'", $adapter::QUERY_MODE_EXECUTE);
        $results = $results->toArray();
        return $results;
    }


    public function getAllProfessorCourses($user_id)
    {
        $adapter = $this->adapter;
        $results = $adapter->query("SELECT c.className, d.title, d.type FROM Professors p INNER JOIN Classes c ON p.professorID = c.professorID INNER JOIN Disciplines d ON d.disciplineID = c.disciplineID WHERE p.user_id = $user_id", $adapter::QUERY_MODE_EXECUTE);
        $results = $results->toArray();
        return $results;
    }
    
    public function deleteUser($user_id){
        $this->tableGateway->delete(array('user_id' => $user_id));
        return true;
    }
    
    
    public function getUser($user_id){
        $sql = new Sql($this->adapter);
        $adapter = $this->adapter;
        $select = $sql->select();
        $select->from('user')
            ->columns(array('*'))
            ->where(array('user_id' => $user_id));
        $selectString = $sql->buildSqlString($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $results = $results->toArray();
        return $results[0];
    }
}
