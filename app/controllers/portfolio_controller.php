<?php

class PortfolioController extends BaseController {

    public static function portfolio() {
        $portfolio = RentalUnit::findPortfolio(1);
        View::make('portfolio/portfolio.html', array('portfolio' => $portfolio));
    }

    public static function newUnit() {
        View::make('portfolio/unit_new.html');
    }

    public static function save() {
        $params = $_POST;
        $unit = new RentalUnit(array(
            'title'=>$params['title'],
            'description'=>$params['description'],
            'address'=>$params['address'],
            'advertised_rent'=>$params['advertised_rent'],
            'area'=>$params['area']
            ));
        
        $unit->save();
        
        Redirect::to('/units/' . $unit->id, array('message'=>'new rental unit added'));
    }

    public static function viewUnit($id) {
        $unit = RentalUnit::find($id);
        View::make('portfolio/unit.html', array('unit' => $unit));
    }

    public static function editUnit($id) {
        $unit = RentalUnit::find($id);
        View::make('portfolio/unit_edit.html', array('unit' => $unit));
    }

}
