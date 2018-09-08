<?php
/**
 * Created by PhpStorm.
 * User: drive867
 * Date: 06.09.2018
 * Time: 20:33
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    //имя перед Action как раз является именем view-представления, для которого он создается
    public function indexAction()
    {
        //при работе данного экшена создастя новый экземпляр Zend\View\Model\ViewModel
        //а потом через $this будем пользоваться, например, в представлении module\Blog\view\blog\index\index.php
        //return new ViewModel();
    }
}