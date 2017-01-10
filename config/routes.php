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
$routes->get('/item/', function() {
  ItemController::index();
//  HelloWorldController::items_list();
});
$routes->post('/item', function() {
  ItemController::store();
});
$routes->get('/item/new', function() {
  ItemController::create();
});
$routes->get('/item/:id', function($id) {
  ItemController::show($id);
});
$routes->get('/item/:id/edit', function($id) {
  ItemController::edit($id);
});
$routes->post('/item/:id/edit', function($id) {
  ItemController::update($id);
});
$routes->post('/item/:id/destroy', function($id) {
  ItemController::destroy($id);
});
//$routes->get('/items/1', function() {
//    HelloWorldController::item_show();
//});
