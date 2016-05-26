<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */


namespace Dashboard\Dashboard\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;

class DashboardTable extends AbstractTableGateway
{


    protected $table = 'user';
    protected $tableGateway;
    protected $adapter;

    public function __construct(Adapter $adapter, TableGateway $tableGateway)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Dashboard());
        $this->tableGateway = $tableGateway;
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

    public function getAllProfessorCourses($user_id)
    {
        $adapter = $this->adapter;
        $results = $adapter->query("SELECT c.className, d.title, d.type FROM Professors p INNER JOIN Classes c ON p.professorID = c.professorID INNER JOIN Disciplines d ON d.disciplineID = c.disciplineID WHERE p.user_id = $user_id", $adapter::QUERY_MODE_EXECUTE);
        $results = $results->toArray();
        return $results;
    }
}
