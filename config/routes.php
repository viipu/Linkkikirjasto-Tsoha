<?php

$routes->get('/', function() {
  ItemController::index();
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

$routes->get('/item/', function() {
  ItemController::index();
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

$routes->get('/account/', function() {
  AccountController::index();
});
$routes->get('/account/:id', function($id) {
  AccountController::show($id);
});
$routes->get('/login', function(){
  AccountController::login();
});
$routes->post('/login', function(){
  AccountController::handle_login();
});
$routes->post('/logout', function(){
  AccountController::logout();
});
