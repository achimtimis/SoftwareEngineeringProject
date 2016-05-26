<?php
namespace Courses;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

use Courses\Courses\Model\CoursesTable;
use Courses\Courses\Model\Courses;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Courses\Courses\Model\CoursesTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $tableGateway = $sm->get('CoursesTableGateway');
                    $studentGateway = $sm->get('StudentTableGateway');
                    $professorGateway = $sm->get('ProfessorTableGateway');
                    $table = new CoursesTable($dbAdapter,$tableGateway, $studentGateway, $professorGateway);
                    return $table;
                },
                'CoursesTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Courses());

                    return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
                },
                'StudentTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Courses());

                    return new TableGateway('students', $dbAdapter, null, $resultSetPrototype);
                },
                'ProfessorTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Courses());

                    return new TableGateway('professors', $dbAdapter, null, $resultSetPrototype);
                },
            ),
            'aliases' => array(
                'zfdb_adapter' => 'Zend\Db\Adapter\Adapter',
            ),
        );
    }
}
