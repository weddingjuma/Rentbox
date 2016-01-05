<?php

class PortfolioController extends BaseController {

    public static function portfolio() {
        $portfolio = RentalUnit::findPortfolio(PortfolioController::get_user_logged_in()->id);
        View::make('portfolio/portfolio.html', array('portfolio' => $portfolio));
    }

    public static function newUnit() {
        View::make('portfolio/unit_new.html');
    }

    public static function save() {
        $params = $_POST;
        $unit = new RentalUnit(array(
            'address' => $params['address'],
            'area' => $params['area']
        ));

        if ($unit->validateAddress($params['address'])) {
            $unit->save(PortfolioController::get_user_logged_in()->id);
            Redirect::to('/units/' . $unit->id, array('message' => 'new rental unit added'));
        } else {
            View::make('portfolio/unit_new.html', array('message' => 'address is too short'));
        }
    }

    public static function updateUnit($id) {
        $params = $_POST;
        $unit = RentalUnit::find($id);
        $unit->advertised_rent = $params['advertised_rent'];
        $unit->title = $params['title'];
        $unit->description = $params['description'];

        $unit->updateUnit();

        Redirect::to('/units/' . $unit->id, array('message' => 'rental unit updated'));
    }

    public static function delete($id) {
        $unit = RentalUnit::find($id);
        $unit->delete();
        Redirect::to('/units', array('message' => 'rental unit deleted'));
    }

    public static function editUnit($id) {
        $unit = RentalUnit::find($id);
        View::make('portfolio/unit_edit.html', array('unit' => $unit));
    }

}
