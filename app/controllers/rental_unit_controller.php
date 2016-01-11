<?php

class RentalUnitController extends BaseController {

    public static function redirect_if_rental_unit_does_not_exist($id) {
        if (!RentalUnit::find($id)) {
            Redirect::to('/search/?search_term=');
        }
    }

    public static function newUnit() {
        View::make('rental_unit/unit_modify.html');
    }

    public static function viewUnit($id) {
        $unit = RentalUnit::find($id);
        $amenities = Amenity::all_and_check(Amenity::RENTAL_UNIT, $id);
        $landlord = User::find($unit->landlord);
        $user = parent::get_user_logged_in();
        $leases = Lease::find_leases_for($id);
        $disabled = null;
        if ($user->id != $landlord->id) {
            $disabled = 'disabled';
        }
        View::make('rental_unit/unit.html', array(
            'unit' => $unit,
            'amenities' => $amenities,
            'landlord' => $landlord,
            'leases' => $leases,
            'disabled' => $disabled));
    }

    public static function save() {
        $params = $_POST;
        $unit = new RentalUnit(array(
            'address' => $params['address'],
            'area' => $params['area']
        ));
        if ($unit->validate()) {
            $unit->save(self::get_user_logged_in()->id);
            Redirect::to('/units/' . $unit->id, array('message' => 'new rental unit added'));
        } else {
            $errors = array_values($unit->errors());
            Redirect::to('/units/new', array('errors' => $errors, 'unit' => $params));
        }
    }

    public static function updateUnit($id) {
        if (self::logged_in_user_is_landlord_of($id)) {
            $params = $_POST;
            $unit = RentalUnit::find($id);
            $unit->description_title = $params['description_title'];
            $unit->description = $params['description'];
            $unit->advertised_rent = $params['advertised_rent'];
            if ($unit->validate()) {
                $unit->updateUnit();
            } else {
                $errors = array_values($unit->errors());
                Redirect::to('/units/' . $unit->id, array('errors' => $errors));
            }
            Amenity::update_amenities_of(Amenity::RENTAL_UNIT, $id, $params);
            Redirect::to('/units/' . $unit->id, array('message' => 'rental unit updated'));
        }
        Redirect::to('/units/' . $id, array('message' => 'insufficient rights'));
    }

    public static function delete($id) {
        if (self::logged_in_user_is_landlord_of($id)) {
            $unit = RentalUnit::find($id);
            $unit->delete();
            Redirect::to('/units', array('message' => 'rental unit deleted'));
        }
        Redirect::to('/units/' . $id, array('message' => 'insufficient rights'));
    }

    public static function editUnit($id) {
        $unit = RentalUnit::find($id);
        View::make('rental_unit/unit_modify.html', array('unit' => $unit, 'edit' => true));
    }

    public static function saveEditUnit($id) {
        if (self::logged_in_user_is_landlord_of($id)) {
            $params = $_POST;
            $unit = RentalUnit::find($id);
            $unit->address = $params['address'];
            $unit->area = $params['area'];
            if ($unit->validate()) {
                $unit->updateUnit();
                Redirect::to('/units/' . $unit->id, array('message' => 'rental unit updated'));
            } else {
                View::make('rental_unit/unit_modify.html', array('errors' => $unit->errors(), 'unit' => $unit, 'edit' => true));
            }
        }
        Redirect::to('/units/' . $id, array('message' => 'insufficient rights'));
    }

}
