<?php
/**
 * Created by PhpStorm.
 * User: drive867
 * Date: 08.09.2018
 * Time: 18:34
 */
namespace Application\Controller;

use Zend\Mvc\MvcEvent;

class BaseAdminController extends BaseController
{
    public function onDispatch(MvcEvent $e)
    {
        //возвращаем результат вызова родительского метода
        return parent::onDispatch($e);
    }
}