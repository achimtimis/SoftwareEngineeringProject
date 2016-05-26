<?php
namespace Users;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

use Users\Users\Model\UsersTable;
use Users\Users\Model\Users;
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
                'Users\Users\Model\UsersTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $tableGateway = $sm->get('UsersTableGateway');
                    $studentGateway = $sm->get('StudentTableGateway');
                    $professorGateway = $sm->get('ProfessorTableGateway');
                    $table = new UsersTable($dbAdapter,$tableGateway, $studentGateway, $professorGateway);
                    return $table;
                },
                'UsersTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Users());

                    return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
                },
                'StudentTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Users());

                    return new TableGateway('students', $dbAdapter, null, $resultSetPrototype);
                },
                'ProfessorTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Users());

                    return new TableGateway('professors', $dbAdapter, null, $resultSetPrototype);
                },
            ),
            'aliases' => array(
                'zfdb_adapter' => 'Zend\Db\Adapter\Adapter',
            ),
        );
    }
}
