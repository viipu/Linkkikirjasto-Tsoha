<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});
$routes->get('/loans', function() {
    HelloWorldController::loans_list();
});
$routes->get('/loans/1', function() {
    HelloWorldController::item_show();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});
$routes->get('/items', function() {
  HelloWorldController::items_list();
});
$routes->get('/items/1', function() {
  HelloWorldController::item_show();
});
