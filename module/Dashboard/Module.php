<?php
namespace Dashboard;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

use Dashboard\Dashboard\Model\DashboardTable;
use Dashboard\Dashboard\Model\Dashboard;
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
                'Users\Users\Model\DashboardTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $tableGateway = $sm->get('DashboardTableGateway');
                    $table = new DashboardTable($dbAdapter,$tableGateway);
                    return $table;
                },
                'DashboardTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Dashboard());

                    return new TableGateway('tracktasyDashboard', $dbAdapter, null, $resultSetPrototype);
                },
            ),
            'aliases' => array(
                'zfdb_adapter' => 'Zend\Db\Adapter\Adapter',
            ),
        );
    }
}
