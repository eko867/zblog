<?php
/**
 * Created by PhpStorm.
 * User: drive867
 * Date: 07.09.2018
 * Time: 10:55
 */

namespace Admin;

class Module
{
    //откуда нашему модулю взять конфиг
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    //откуда модуль получит исходники
    //__NAMESPACE__ будет Admin
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__, //Admin => _DIR_/src/Admin
                ),
            ),
        );
    }
}
