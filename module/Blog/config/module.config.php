<?php
/**
 * Created by PhpStorm.
 * User: drive867
 * Date: 06.09.2018
 * Time: 20:32
 */

return array(

    'doctrine' => [ //настройка entities settings
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'blog_entity' => [ //псевдоним нашей конфигурации //annotation driver
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__.'/../src/Blog/Entity', //здесь будем хранить классы для сущностей нашей БД

                ],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    //'My\Namespace' => 'my_annotation_driver',
                    'Blog\Entity' => 'blog_entity',
                ],
            ],
        ],
    ],


    'controllers' => array(
        'invokables' => array(
            'Blog\Controller\Index' => 'Blog\Controller\IndexController' //псевдоним => полное название
        ),
    ),

    'router' => array(
        'routes' => array(
            'blog' => array( //как бы псевдоним нашего маршрута
                'type' => 'segment', //означает, что 'route' с подстановками типа :action, :id
                'options' => array(
                    'route'    => '/[:action/][:id/]', //cам маршрут
                    'constraints' => array( //и ограничения записанные через регулярки
                        'action'=> '[a-zA-Z][a-zA-Z0-9_-]',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array( //какой у маршрута Blog контроллер и экшн по умолчанию
                        'controller' => 'Blog\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(  //путь до файлов с представлениями(view)
            __DIR__ . '/../view',
        ),
    ),

);
