<?php
/**
 * Created by PhpStorm.
 * User: drive867
 * Date: 07.09.2018
 * Time: 10:56
 */

return array(
    //настройки entities settings доктрины не указываем, так как они уже есть в модуле Blog (+грузим Blog раньше чем Admin)
    /*
    'doctrine' => [ //настройка entities settings
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'admin_entity' => [ //псевдоним нашей конфигурации //annotation driver
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__.'/../src/Admin/Entity', //здесь будем хранить классы для сущностей нашей БД

                ],
            ],


            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    //'My\Namespace' => 'my_annotation_driver',
                    'Admin\Entity' => 'admin_entity',
                ],
            ],
        ],
    ],
    */

    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController', //псевдоним => полное название
            'category' => 'Admin\Controller\CategoryController' //псевдоним => полное название
        ),
    ),

    'router' => array(
        'routes' => array(

            'admin' => array( //псевдоним  1-го маршрута
                'type' => 'literal', //означает, что 'route' без подстановок
                'options' => array(
                    'route' => '/admin/', //cам маршрут
                    'defaults' => array( //какой у admin маршрута контроллер и экшн по умолчанию
                        'controller' => 'Admin\Controller\Index', //cм.раздел 'controllers'
                        'action' => 'index',
                    ),
                ),

                'may_terminate' => true,//?

                // у 1-го маршрута есть подмаршруты (т.е /admin/...)
                'child_routes' => array(
                    'category' => array( // псевдоним маршрута 1.1
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'category/[:action/][:id/]', // т.е /admin/category/...
                            'defaults' => array(
                                'controller' => 'category', //cм.раздел 'controllers'
                                'action' => 'index'
                            ),
                        ),
                    ),//сategory
                ),//child_routes
            ),//admin


            'hello' => array( // псевдоним  2-го маршрута
                'type' => 'literal', //означает, что 'route' без подстановок
                'options' => array(
                    'route' => '/hello/', //cам маршрут
                    'defaults' => array( //какой у hello маршрута контроллер и экшн по умолчанию
                        'controller' => 'Admin\Controller\Index', //для балды
                        'action' => 'index', //для балды
                    ),
                ),

                'may_terminate' => true,//?

                // у 2-го маршрута есть подмаршруты (т.е /hello/...)
                'child_routes' => array(
                    'kitty' => array( // псевдоним маршрута 2.1
                        'type' => 'literal',
                        'options' => array(
                            'route' => 'kitty/', //предполагается  /hello/kitty/
                            'defaults' => array(
                                'controller' => 'category',//для балды
                                'action' => 'index'// для балды
                            ),
                        ),
                    ),
                ),
            ),//hello

        ),//routes
    ),//router

    'view_manager' => array(
        'template_path_stack' => array(  //путь до файлов с представлениями(view)
            __DIR__ . '/../view',
        ),
    ),

);