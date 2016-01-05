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
        // Toteuta kirjautumisen tarkistus tähän.
        // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).
    }

    public static function permission_to_modify($id) {
        if (!RentalUnit::find($id)->landlord == self::get_user_logged_in()->id) {
            Redirect::to('/units/' . $id, array('message' => 'insufficient rights'));
        };
    }

}
