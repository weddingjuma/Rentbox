<?php

class SearchController extends BaseController {

    public static function all() {
        $searchResults = RentalUnit::searchAll();
        View::make('search/results.html', array('searchResults' => $searchResults));
    }

}
