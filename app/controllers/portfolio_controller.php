<?php

class PortfolioController extends BaseController {

    public static function portfolio() {
        $portfolio = RentalUnit::findPortfolio(parent::get_user_logged_in()->id);
        View::make('portfolio/portfolio.html', array('portfolio' => $portfolio));
    }

}
