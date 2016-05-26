<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    protected $whitelist = array('zfcuser/login');

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        // check page name
        $sm = $e->getApplication()->getServiceManager();

        $router = $sm->get('router');
        $request = $sm->get('request');
        $matchedRoute = $router->match($request);
        $params = $matchedRoute->getParams();

        $controller = $params['controller'];
        $action = $params['action'];

        $module_array = explode('\\', $controller);
        $module = array_pop($module_array);

        $route = $matchedRoute->getMatchedRouteName();

        $e->getViewModel()->setVariables(
            array(
                'CURRENT_MODULE_NAME' => $module,
                'CURRENT_CONTROLLER_NAME' => $controller,
                'CURRENT_ACTION_NAME' => $action,
                'CURRENT_ROUTE_NAME' => $route,
            )
        );


        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) {

            $controller = $e->getTarget();
            $sm = $e->getApplication()->getServiceManager();
            $auth = $sm->get('zfcuser_auth_service');
            if (!$auth->hasIdentity()) {

                // If on login / registration page, let them pass
                if(
                    !($e->getRouteMatch()->getParam('controller', 'index') == 'zfcuser' && $e->getRouteMatch()->getParam('action', 'index') == 'login') &&
                    !($e->getRouteMatch()->getParam('controller', 'index') == 'zfcuser' && $e->getRouteMatch()->getParam('action', 'index') == 'register'))

                    $controller->plugin('redirect')->toRoute('zfcuser/login'); }
        }, 100);  //BIA 
    }

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
}
