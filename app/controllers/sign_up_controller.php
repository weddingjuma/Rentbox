<?php

class SignUpController extends BaseController {

    public static function signup() {
        View::make('/frontpage/index.html');
    }

    public static function createUser() {
        $params = $_POST;
        $sign_up_form = new SignUpForm(array(
            'first_name' => $params['first_name'],
            'last_name' => $params['last_name'],
            'email' => $params['email'],
            'password' => $params['password'],
            'password_confirmation' => $params['password_confirmation']));
        if ($sign_up_form->validate()) {
            $user = new User((array) $sign_up_form);
            $user->save();
            $_SESSION['user'] = $user->id;
            Redirect::to('/units', array('message' => 'Welcome ' . $user->first_name . "!"));
        } else {
            $errors = array_values($sign_up_form->errors());
            Redirect::to('/', array('errors' => $errors, 'input' => $params));
        }
    }

}
