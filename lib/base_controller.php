<?php

class BaseController {

    public static function get_user_logged_in() {
        if (isset($_SESSION['user'])) {
            $user_id = $_SESSION['user'];
            $user = User::find($user_id);
            return $user;
        }
        // Toteuta kirjautuneen käyttäjän haku tähän
        return null;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['user'])) {
            Redirect::to('/', array('message' => 'you need to be logged in for that'));
        }
    }

    public static function logged_in_already() {
        if (isset($_SESSION['user'])) {
            Redirect::to('/search/?search_term=');
        }
    }

    public static function logged_in_user_is_landlord_of($id) {
        if (!RentalUnit::find($id)->landlord == self::get_user_logged_in()->id) {
            return false;
        }
        return true;
    }

}
