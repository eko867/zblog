<?php
/**
 * Created by PhpStorm.
 * User: drive867
 * Date: 08.09.2018
 * Time: 18:18
 */

namespace Application\Controller;
use \Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Doctrine\ORM\EntityManager;

class BaseController extends AbstractActionController
{
    protected $entityManager;//устнавливается при запросе класса через onDispatch()

    public function setEntityManager(EntityManager $entityManager):void
    {
        $this->entityManager=$entityManager;
    }

    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    //? функция вызываемая при активации контроллера на какое-то событие
    public function onDispatch(MvcEvent $e)
    {
        //локатор служб экономит память, при первом обращении в нем регистрируется(создается) нужный cервис(им может быть переменная абсолютно любого типа, не только объект),
        // а дальше к сервису и его методам можно добраться отовсюду

        //т.к. наш класс наследник зендовского класса AbstractActionController, у него есть метод getServiceLocator()
        // который возвращает класс Zend/Service/ServiceLocator (это и есть сервис-менеджер, реализующий паттерн service locator)
        //плюс этот менеджер реализует интерфейс ServiceLocatorInterface с методои get('ClassName')
        $em=$this->getServiceLocator()->get('Doctrine/ORM/EntityManager');
        $this->setEntityManager($em);

        //возвращаем результат вызова родительского метода
        return parent::onDispatch($e);
    }

}
