<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */


namespace Courses\Courses\Model;

use Zend\Form\Annotation;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Courses implements InputFilterAwareInterface
{

    protected $inputFilter;

    public $user_id;
    public $username;
    public $email;
    public $password;
    public $state;
    public $category_id;
    public $display_name;
    public $firstName;
    public $lastName;
    public $groupID;
    public $degree;


    public function exchangeArray($data)
    {
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : 0;
        $this->username = (isset($data['username'])) ? $data['username'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->category_id = (isset($data['category_id'])) ? $data['category_id'] : 0;
        $this->display_name = (isset($data['display_name'])) ? $data['display_name'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
        $this->state = (isset($data['state'])) ? $data['state'] : 0;
        $this->degree = (isset($data['degree'])) ? $data['degree'] : 0;
        $this->firstName = (isset($data['firstName'])) ? $data['firstName'] : null;
        $this->lastName = (isset($data['lastName'])) ? $data['lastName'] : null;
        $this->groupID = (isset($data['groupID'])) ? $data['groupID'] : 0;
        
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            /* $inputFilter->add(array(
                  'name'     => 'sms_type_id',
                  'required' => false,
                  'filters'  => array(
                      array('name' => 'Int'),
                  ),
              ));
             $inputFilter->add(array(
                  'name'     => 'diet_status_id',
                  'required' => false,
              ));*/

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
