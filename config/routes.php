<?php

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

function check_logged_in() {
    BaseController::check_logged_in();
}

$routes->get('/', function() {
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

$routes->get('/search', 'check_logged_in', function() {
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
    RentalUnitController::editUnit($id);
});

$routes->post('/units/:id/edit', 'check_logged_in', function($id) {
    RentalUnitController::saveEditUnit($id);
});

$routes->post('/units/:id', 'check_logged_in', function($id) {
    RentalUnitController::updateUnit($id);
});

$routes->post('/units/:id/delete', 'check_logged_in', function($id) {
    RentalUnitController::delete($id);
});

$routes->get('/units/:id', 'check_logged_in', function($id) {
    RentalUnitController::viewUnit($id);
});

$routes->get('/units/:id/leases/new', 'check_logged_in', function($id) {
    LeaseController::newLease($id);
});

$routes->post('/units/:id/leases/new', 'check_logged_in', function() {
    LeaseController::save();
});

$routes->get('/units/:id/leases/:leaseid', 'check_logged_in', function($id, $leaseid) {
    LeaseController::viewLease($id, $leaseid);
});

$routes->post('/units/:id/leases/:leaseid/delete', 'check_logged_in', function($id, $leaseid) {
    LeaseController::delete($id, $leaseid);
});

$routes->get('/units/:id/leases/:leaseid/edit', 'check_logged_in', function($id, $leaseid) {
    LeaseController::editLease($id, $leaseid);
});

$routes->post('/units/:id/leases/:leaseid/edit', 'check_logged_in', function($id, $leaseid) {
    LeaseController::updateLease($id, $leaseid);
});




