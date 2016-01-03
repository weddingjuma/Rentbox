<?php

class UserController extends BaseController {

    public static function login() {
        $params = $_POST;

        $user = User::authenticate($params['email'], $params['password']);

        if (!$user) {
            View::make('/suunnitelmat/signup.html');
        } else {
            $_SESSION['user'] = $user->id;
            Redirect::to('/units', array('message' => 'Welcome ' . $user->first_name . "!"));
        }
    }

}
