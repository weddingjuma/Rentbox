<?php

//require 'app/models/rental_unit.php';

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('/suunnitelmat/signup.html');
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        //View::make('helloworld.html');
        $room = RentalUnit::find(2);
        $units = RentalUnit::searchAll();
        Kint::dump($room);
        Kint::dump($units);
    }

    public static function searchResults() {
        View::make('/suunnitelmat/search_results.html');
    }

    public static function portfolio() {
        View::make('/suunnitelmat/portfolio.html');
    }

    public static function unit() {
        View::make('/suunnitelmat/unit.html');
    }

    public static function unitEdit() {
        View::make('/suunnitelmat/unit_edit.html');
    }

    public static function lease() {
        View::make('/suunnitelmat/lease.html');
    }

}
