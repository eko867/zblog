<?php
/**
 * Created by PhpStorm.
 * User: drive867
 * Date: 07.09.2018
 * Time: 13:31
 */

namespace Admin\Controller;

//use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Model\ViewModel;
use Application\Controller\BaseAdminController;
use Admin\Form\CategoryAddForm;
use Blog\Entity\Category;

class CategoryController extends BaseAdminController
{
    //имя перед Action как раз является именем view-представления, для которого он создается
    public function indexAction()
    {
        //локатор служб экономит память, при первом обращении в нем регистрируется(создается) нужный cервис(им может быть переменная абсолютно любого типа, не только объект),
        // а дальше к сервису и его методам можно добраться отовсюду

        //т.к. наш класс наследник BaseAdminController, а он наследник зендовского класса AbstractActionController, у него есть метод getServiceLocator()
        // который возвращает класс Zend/Service/ServiceLocator (это и есть сервис-менеджер, реализующий паттерн service locator)
        //плюс этот менеджер реализует интерфейс ServiceLocatorInterface с методои get('ClassName')

        //$entityManager=$this->getServiceLocator()->get('Doctrine/ORM/EntityManager'); //было до BaseController

        //cоздаем запрос на языке DSQL (DoctrineSQL) через методы entityManager'a
        $query = $this->getEntityManager()->createQuery('SELECT u FROM Blog\Entity\Category AS u ORDER BY u.id DESC');
        $rowsWithResult = $query->getResult(); //вернется массив с объектками Blog\Entity\Category

        //var_dump($rowsWithResult);
        return array('rowsWithResult' => $rowsWithResult); //улетит во view/admin/category/index.phtml
        //return $rowsWithResult; //!!! так вьюшка не найдет эту переменную, нужно именно через массив возвращать
    }

    public function addAction()
    {
        $form = new CategoryAddForm();//создаем форму для добавления категории с двумя полями и кнопкой
        $status = $message = '';
        $em = $this->getEntityManager();

        $request = $this->getRequest(); //тут будут данные о том, как произошел запрос (как пользователь нарвался на данный экшн)

        if ($request->isPost()) {
            //если на странице с формой мы ввели данные и отправили данные через POST
            $form->setData($request->getPost()); //то теперь выгружаем данные в наш объект формы и обрабатываем ее
            if ($form->isValid()) { //пока у нас в классе формы не прикручен Filter будет всегда true

                $category = new Category();
                $category->exchangeArray($form->getData()); //заполнить объект категории данными из формы

                $em->persist($category);//подсовываем менеджеру нашу сущность с уже обновленными данными
                $em->flush();//оканчиваем работу с менеждером

                $status = 'success';
                $message = 'Category was added';
            } else {
                $status = 'error';
                $message = 'Wrong parameters';
            }
        } else {
            //если мы еще только оказались на странице с формой, то экшн должен отдать незаполненный объект формы
            //и далее пойдет работать вьюшка \module\Admin\view\admin\category\add.phtml
            return ['form' => $form];
        }

        if ($message) { //для перехвата ошибок (их распечатаем на /admin/category/index.phtml)
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        //редиректимся на indexAction (/admin/category/index.phtml)
        return $this->redirect()->toRoute('admin/category');//почему-то именно так, никаких других вариаций /
    }

    public function editAction()
    {
        $form = new CategoryAddForm();//создаем форму для добавления категории с двумя полями и кнопкой
        $status = $message = '';
        $em = $this->getEntityManager();

        //получаем id статьи которую будем редактировать (за счет плагина Params)
        $id = (int)$this->params()->fromRoute('id', 0);
        //получаем саму категорию от менеджера
        $category = $em->find('Blog\Entity\Category', $id);

        //если такой категории нету, то редиректимся в админку
        if (empty($category)) {
            $message = 'Category not found';
            $status = 'error';
            //у родительского контроллера есть плагины(Redirect,FlashMessenger,Url,Params,Layout,Forward)
            //у уже у плагинов свои методы
            //попасть к плагину можно за счет магич.метода __call()
            //достаточно у объекта контроллера вызвать поле с названием плагина (а дальше можно и методы плагина)
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
            return $this->redirect()->toRoute('admin/category');//почему-то именно так, никаких других вариаций /
        }

        //до этого момента форма была пустая
        //теперь связываем форму с полями из $category
        $form->bind($category);//метод требует наличия у класса Category метода getArrayCopy()
        //читаем запрос (чтобы оттуда получить свежие данные для манипуляции с $category)
        $request=$this->getRequest();

        if ($request->isPost()) { //если пользователь нажал кнопочку, то надо прочитать, что было в форме и внести изменения в категорию)
            $data = $request->getPost();
            $form->setData($data);
            if ($form->isValid()) {//если с формой все збс (так оно и будет, т.к фильтра пока нету), то ее данные можно занести в $category через менеджера
                $em->persist($category);
                $em->flush();
                $status = 'success';
                $message = 'Category was updated';
            } else {
                $status = 'error';
                $message = 'Wrong fields in form';
                foreach ($form->getInputFilter()->getInvalidInput() as $badInput) {
                    foreach ($badInput->getMessages() as $msg) {
                        $message .= $msg . ', ';
                    }
                }
            }
        } else {//если кнопку не нажимали, то тупо кидаем во вью нашу форму с текущими полями категории
            return ['form'=>$form, 'id'=>$id];
        }

        //печатаем результат работы после нажатой кнопки и редиректимся на indexAction (/admin/category/index.phtml)
        if ($message) { //для перехвата ошибок (их распечатаем на /admin/category/index.phtml)
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }
        return $this->redirect()->toRoute('admin/category');//почему-то именно так, никаких других вариаций /
    }

    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        $em=$this->getEntityManager();

        try{
            //узнаем где лежат сущности
            $repository=$em->getRepository('Blog\Entity\Category');
            $item=$repository->find($id);
            // $category = $em->find('Blog\Entity\Category', $id); //можно было без явного репозитория
            $em->remove($item);
            $em->flush();
            $status='success';
            $message='Category was deleted';
        } catch (\Exception $ex){
            $status='error';
            $message='Can\'t delete this category '.$ex->getMessage();
        }

        $this->flashMessenger()->setNamespace($status)->addMessage($message);
        return $this->redirect()->toRoute('admin/category');
    }
}