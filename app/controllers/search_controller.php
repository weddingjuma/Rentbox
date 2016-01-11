<?php

class SearchController extends BaseController {

    public static function all() {
        $params = $_GET;
        $searchResults = RentalUnit::search($params['search_term']);
        View::make('search/results.html', array('searchResults' => $searchResults));
    }

}
