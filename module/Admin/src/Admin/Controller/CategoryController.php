<?php
/**
 * Created by PhpStorm.
 * User: drive867
 * Date: 07.09.2018
 * Time: 13:31
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Model\ViewModel;

class CategoryController extends AbstractActionController
{
    //имя перед Action как раз является именем view-представления, для которого он создается
    public function indexAction()
    {
        //локатор служб экономит память, при первом обращении в нем регистрируется(создается) нужный cервис(им может быть переменная абсолютно любого типа, не только объект),
        // а дальше к сервису и его методам можно добраться отовсюду

        //т.к. наш класс наследник  зендовского класса AbstractActionController, у него есть метод getServiceLocator()
        // который возвращает класс Zend/Service/ServiceLocator (это и есть сервис-менеджер, реализующий паттерн service locator)
        //плюс этот менеджер реализует интерфейс ServiceLocatorInterface с методои get('ClassName')

        $entityManager=$this->getServiceLocator()->get('Doctrine/ORM/EntityManager');
        //cоздаем запрос на языке DSQL (DoctrineSQL)
        $query=$entityManager->createQuery('SELECT u FROM Blog\Entity\Category AS u ORDER BY u.id DESC');
        $rowsWithResult=$query->getResult(); //вернется массив с объектками Blog\Entity\Category

        //var_dump($rowsWithResult);
        return array('rowsWithResult'=>$rowsWithResult); //улетит во view/admin/category/index.phtml
        //return $rowsWithResult; //!!! так вьюшка не найдет эту переменную, нужно именно через массив возвращать
    }
}