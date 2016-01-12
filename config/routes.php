<?php

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

function check_logged_in() {
    BaseController::check_logged_in();
}

function logged_in_already() {
    BaseController::logged_in_already();
}

$routes->get('/', 'logged_in_already', function() {
    SignUpController::signup();
});

$routes->post('/signup', function() {
    SignUpController::createUser();
});

$routes->post('/login', function() {
    UserController::login();
});

$routes->post('/logout', 'check_logged_in', function() {
    UserController::logout();
});

$routes->get('/search/', 'check_logged_in', function() {
    SearchController::all();
});

$routes->get('/units', 'check_logged_in', function() {
    PortfolioController::portfolio();
});

$routes->post('/units', 'check_logged_in', function() {
    RentalUnitController::save();
});

$routes->get('/units/new', 'check_logged_in', function() {
    RentalUnitController::newUnit();
});

$routes->get('/units/:id/edit', 'check_logged_in', function($id) {
    RentalUnitController::redirect_if_rental_unit_does_not_exist($id);
    RentalUnitController::editUnit($id);
});

$routes->post('/units/:id/edit', 'check_logged_in', function($id) {
    RentalUnitController::redirect_if_rental_unit_does_not_exist($id);
    RentalUnitController::saveEditUnit($id);
});

$routes->post('/units/:id', 'check_logged_in', function($id) {
    RentalUnitController::redirect_if_rental_unit_does_not_exist($id);
    RentalUnitController::updateUnit($id);
});

$routes->post('/units/:id/delete', 'check_logged_in', function($id) {
    RentalUnitController::redirect_if_rental_unit_does_not_exist($id);
    RentalUnitController::delete($id);
});

$routes->get('/units/:id', 'check_logged_in', function($id) {
    RentalUnitController::redirect_if_rental_unit_does_not_exist($id);
    RentalUnitController::viewUnit($id);
});

$routes->get('/units/:id/leases/new', 'check_logged_in', function($id) {
    RentalUnitController::redirect_if_rental_unit_does_not_exist($id);
    LeaseController::newLease($id);
});

$routes->post('/units/:id/leases/new', 'check_logged_in', function($id) {
    RentalUnitController::redirect_if_rental_unit_does_not_exist($id);
    LeaseController::save();
});

$routes->get('/units/:id/leases/:leaseid', 'check_logged_in', function($id, $leaseid) {
    RentalUnitController::redirect_if_rental_unit_does_not_exist($id);
    LeaseController::redirect_if_lease_does_not_exist($leaseid);
    LeaseController::viewLease($id, $leaseid);
});

$routes->post('/units/:id/leases/:leaseid/delete', 'check_logged_in', function($id, $leaseid) {
    RentalUnitController::redirect_if_rental_unit_does_not_exist($id);
    LeaseController::redirect_if_lease_does_not_exist($leaseid);
    LeaseController::delete($id, $leaseid);
});

$routes->get('/units/:id/leases/:leaseid/edit', 'check_logged_in', function($id, $leaseid) {
    RentalUnitController::redirect_if_rental_unit_does_not_exist($id);
    LeaseController::redirect_if_lease_does_not_exist($leaseid);
    LeaseController::editLease($id, $leaseid);
});

$routes->post('/units/:id/leases/:leaseid/edit', 'check_logged_in', function($id, $leaseid) {
    RentalUnitController::redirect_if_rental_unit_does_not_exist($id);
    LeaseController::redirect_if_lease_does_not_exist($leaseid);
    LeaseController::updateLease($id, $leaseid);
});




