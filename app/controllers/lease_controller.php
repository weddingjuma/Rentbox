<?php

class LeaseController extends BaseController {

    public static function viewLease($id, $leaseId) {
        if (parent::logged_in_user_is_landlord_of($id)) {

            $unit = RentalUnit::find($id);
            $lease = Lease::find($leaseId);
            $amenities = Amenity::find_amenities_for_rental_unit($id);
            $user = parent::get_user_logged_in();

            View::make('lease/lease.html', array(
                'lease' => $lease,
                'unit' => $unit,
                'amenities' => $amenities,
                'user' => $user,
            ));
        }
        Redirect::to('/units/' . $id, array('message' => 'insufficient rights'));
    }

    public static function newLease($id) {
        if (parent::logged_in_user_is_landlord_of($id)) {

            $unit = RentalUnit::find($id);
            $amenities = Amenity::find_amenities_for_rental_unit($id);
            $user = parent::get_user_logged_in();

            View::make('lease/lease_modify.html', array(
                'unit' => $unit,
                'amenities' => $amenities,
                'user' => $user));
        }
        Redirect::to('/units/' . $id, array('message' => 'insufficient rights'));
    }

    public static function save() {
        $params = $_POST;
        if (parent::logged_in_user_is_landlord_of($params['rental_unit'])) {

            $lease = new Lease(array(
                'tenant' => $params['tenant'],
                'tenant_email' => $params['tenant_email'],
                'rent' => $params['rent'],
                'start_date' => $params['start_date'],
                'end_date' => $params['end_date'],
                'rental_unit' => $params['rental_unit']
            ));

            if ($lease->validate()) {
                $lease->save();
                Redirect::to('/units/' . $params['rental_unit'], array('message' => 'new lease added'));
            } else {
                $errors = array_values($lease->errors());
                Redirect::to('/units/' . $params['rental_unit'] . '/leases/new', array('errors' => $errors, 'input' => $params, 'unit' => RentalUnit::find($params['rental_unit'])));
            }
        }
        Redirect::to('/units/' . $params['rental_unit'], array('message' => 'insufficient rights'));
    }

    public static function delete($id, $leaseid) {
        if (parent::logged_in_user_is_landlord_of($id)) {

            $lease = Lease::find($leaseid);
            $lease->delete();
            Redirect::to('/units/' . $id, array('message' => 'lease deleted'));
        }
        Redirect::to('/units/' . $id, array('message' => 'insufficient rights'));
    }

    public static function editLease($id, $leaseId) {
        if (parent::logged_in_user_is_landlord_of($id)) {

            $unit = RentalUnit::find($id);
            $lease = Lease::find($leaseId);
            $amenities = Amenity::find_amenities_for_rental_unit($id);
            $user = parent::get_user_logged_in();

            View::make('lease/lease_modify.html', array(
                'lease' => $lease,
                'unit' => $unit,
                'amenities' => $amenities,
                'user' => $user,
                'input' => array(
                    'tenant' => $lease->tenant,
                    'tenant_email' => $lease->tenant_email,
                    'rent' => $lease->rent,
                    'start_date' => $lease->start_date,
                    'end_date' => $lease->end_date),
                'edit' => true));
        }
        Redirect::to('/units/' . $id, array('message' => 'insufficient rights'));
    }

    public static function updateLease($id, $leaseId) {
        $params = $_POST;
        if (parent::logged_in_user_is_landlord_of($id)) {

            $lease = new Lease(array(
                'id' => $leaseId,
                'tenant' => $params['tenant'],
                'tenant_email' => $params['tenant_email'],
                'rent' => $params['rent'],
                'start_date' => $params['start_date'],
                'end_date' => $params['end_date'],
                'rental_unit' => $params['rental_unit']
            ));

            if ($lease->validate()) {
                $lease->update();
                Redirect::to('/units/' . $params['rental_unit'], array('message' => 'lease updated'));
            } else {
                $errors = array_values($lease->errors());
                Redirect::to('/units/' . $params['rental_unit'] . '/leases/' . $leaseId . '/edit', array('errors' => $errors, 'input' => $params, 'unit' => RentalUnit::find($params['rental_unit'])));
            }
        }
        Redirect::to('/units/' . $params['rental_unit'], array('message' => 'insufficient rights'));
    }

}
