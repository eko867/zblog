<?php
/**
 * Created by PhpStorm.
 * User: drive867
 * Date: 06.09.2018
 * Time: 20:30
 */

namespace Blog;

class Module
{
    //откуда нашему модулю взять конфиг
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    //откуда модуль получит исходники
    //__NAMESPACE__ будет Blog
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__, //Blog => _DIR_/src/Blog
                ),
            ),
        );
    }
}
