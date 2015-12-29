<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/user/unit', function() {
    HelloWorldController::unit();
});

$routes->get('/user/unit/edit', function() {
    HelloWorldController::unitEdit();
});

$routes->get('/units/:id/lease', function() {
    HelloWorldController::lease();
});

$routes->get('/search', function() {
    SearchController::all();
});

$routes->get('/units', function() {
    PortfolioController::portfolio();
});

$routes->post('/units', function() {
    PortfolioController::save();
});

$routes->get('/units/new', function() {
    PortfolioController::newUnit();
});

$routes->get('/units/:id/edit', function($id) {
    PortfolioController::editUnit($id);
});

$routes->get('/units/:id', function($id) {
    PortfolioController::viewUnit($id);
});

