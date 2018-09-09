<?php
/**
 * Created by PhpStorm.
 * User: drive867
 * Date: 08.09.2018
 * Time: 21:35
 */

namespace Admin\Form;

use Zend\Form\Form;

//use Zend\InputFilter\InputFilter; //пока что данные в форме не будем фильтровать
//use Zend\InputFilter\Factory as InputFactory;

class CategoryAddForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('categoryAddForm');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'bs-example form-horizontal');

        //$this->setInputFilter(new CategoryInputFilter());

        $this->add([ //первое поле формы
            'name' => 'categoryKey',
            'type' => 'Text',
            'options' => [
                'min' => 3, //количество символов в поле формы
                'max' => 100,
                'label' => 'Ключ',
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => 'required', //поле формы обязательно для заполнения
            ],
        ]);

        $this->add([ //второе поле формы
            'name' => 'categoryName',
            'type' => 'Text',
            'options' => [
                'min' => 3, //количество символов в поле формы
                'max' => 100,
                'label' => 'Название',
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => 'required',
            ],
        ]);

        $this->add([ //третий элемент формы - это кнопка
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Сохранить',
                'id' => 'btn_submit',
                'class' => 'btn btn-primary',
            ],
        ]);


    }
}