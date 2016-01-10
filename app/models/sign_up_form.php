<?php

class SignUpForm extends BaseModel {

    public $first_name, $last_name, $email, $password, $password_confirmation;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validation_rules = array(
            'required' => array(array('first_name'), array('last_name'), array('email'), array('password'), array('password_confirmation')),
            'email' => array(array('email')),
            'equals' => array(array('password', 'password_confirmation'))
        );
    }

    public function validate() {
        return(parent::validate() && !User::findWithEmail($this->email));
    }
    
    public function errors() {
        $errors = parent::errors();
        if(User::findWithEmail($this->email)){
            $errors[] = array('Email registered already');
        }
        return $errors;
    }

}
