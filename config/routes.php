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
$routes->get('/item', function() {
    ItemController::index();
//  HelloWorldController::items_list();
});
$routes->post('/item', function(){
  ItemController::store();
});
$routes->get('/item/new', function(){
  ItemController::create();
});
$routes->get('/item/:id', function($id) {
    ItemController::show($id);
});
//$routes->get('/items/1', function() {
//    HelloWorldController::item_show();
//});
