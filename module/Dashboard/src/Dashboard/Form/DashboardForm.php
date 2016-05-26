<?php

namespace adminuser\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter;

class DashboardForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct($name);
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'user_id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'username',
            'type' => 'text',
            'attributes' => array(
                'id' => 'username',
                'class'=>"form-control",
                'placeholder'=>'Enter Username'
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'type' => 'email',
            'attributes' => array(
                'id' => 'email',
                'class'=>"form-control",
                'placeholder'=>'Enter Email'
            ),
        ));

        $this->add(array(
            'name' => 'category_id',
            'type' => 'Hidden',
        ));
        
        
        $this->add(array(
            'name' => 'display_name',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'password',
            'attributes' => array(
                'class'=>"form-control",
                'placeholder'=>'Enter Password'
            ),
        ));

        $this->add(array(
            'name' => 'state',
            'type' => 'select',
            'options'=> array(
                'value_options'=> array(
                    '0' => 'Inactive',
                    '1' => 'Active'
                )
            ),
            'attributes' => array(
                'id' => 'state',
                'class'=>"form-control",
            ),
        ));

        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel('> Save')
            ->setAttributes(array(
                'type'  => 'submit',
                'class'=>"btn btn-sm btn-primary",
            ));

        $this->add($submitElement, array(
            'priority' => -100,
        ));

    }
} 