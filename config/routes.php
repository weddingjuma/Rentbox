<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/search', function(){
      HelloWorldController::searchResults();
  });

    $routes->get('/user/unit', function() {
    HelloWorldController::unit();
});

    $routes->get('/user/unit/edit', function() {
    HelloWorldController::unitEdit();
});

    $routes->get('/user/unit/lease', function() {
    HelloWorldController::lease();
});


    $routes->get('/user/portfolio', function() {
    HelloWorldController::portfolio();
});

