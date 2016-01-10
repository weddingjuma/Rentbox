<?php

class UserController extends BaseController {

    public static function login() {
        $params = $_POST;
        $user = User::authenticate($params['email'], $params['password']);
        if (!$user) {
            Redirect::to('/', array('login_error' => 'Wrong email or password'));
        } else {
            $_SESSION['user'] = $user->id;
            Redirect::to('/units', array('message' => 'Welcome ' . $user->first_name . "!"));
        }
    }

    public static function logout() {
        $_SESSION['user'] = null;
        Redirect::to('/', array('message' => 'you have logged out'));
    }

}
