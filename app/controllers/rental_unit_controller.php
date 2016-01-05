<?php

class RentalUnitController extends BaseController {

    public static function viewUnit($id) {
        $unit = RentalUnit::find($id);
        $landlord = User::find($unit->landlord);
        $user = RentalUnitController::get_user_logged_in();
        View::make('portfolio/unit.html', array('unit' => $unit, 'landlord' => $landlord, 'user' => $user));
    }

}
