<?php

namespace users\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter;

class UsersForm extends Form
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
            'name' => 'professorID',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'studID',
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
            'type' => 'select',
            'options'=> array(
                'value_options'=> array(
                    '1' => 'Admin',
                    '2' => 'Profesor',
                    '3' => 'Student',
                    
                )
            ),
            'attributes' => array(
                'id' => 'category_id',
                'class'=>"form-control",
            ),
        ));
        
        
        $this->add(array(
            'name' => 'display_name',
            'type' => 'Text',
            'attributes' => array(
                'class'=>"form-control",
                'placeholder'=>'Enter Display Name'
            ),
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

        $this->add(array(
            'name' => 'groupID',
            'type' => 'select',
            'attributes' => array(
                'id' => 'groupID',
                'class'=>"form-control",
                'placeholder'=>'Enter Group'
            ),
        ));

        $this->add(array(
            'name' => 'degree',
            'type' => 'text',
            'attributes' => array(
                'id' => 'degree',
                'class'=>"form-control",
                'placeholder'=>'Enter Degree'
            ),
        ));

        $this->add(array(
            'name' => 'firstNameProfessor',
            'type' => 'text',
            'attributes' => array(
                'id' => 'firstName',
                'class'=>"form-control",
                'placeholder'=>'Enter First Name'
            ),
        ));

        $this->add(array(
            'name' => 'lastNameProfessor',
            'type' => 'Text',
            'attributes' => array(
                'id' => 'lastName',
                'class'=>"form-control",
                'placeholder'=>'Enter Last Name'
            ),
        ));

        $this->add(array(
            'name' => 'firstNameStudent',
            'type' => 'text',
            'attributes' => array(
                'id' => 'firstName',
                'class'=>"form-control",
                'placeholder'=>'Enter First Name'
            ),
        ));

        $this->add(array(
            'name' => 'lastNameStudent',
            'type' => 'Text',
            'attributes' => array(
                'id' => 'lastName',
                'class'=>"form-control",
                'placeholder'=>'Enter Last Name'
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