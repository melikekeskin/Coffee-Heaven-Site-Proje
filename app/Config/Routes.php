<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Anasayfa::index');
$routes->match(['get','post'],'icecekler', 'Anasayfa::icecekler');

$routes->match(['get','post'],'order_form', 'Anasayfa::order_form');
$routes->match(['get','post'],'login', 'Anasayfa::login');
$routes->get('logout', 'Anasayfa::logout');

$routes->get('panel', 'Panel::index');
$routes->match(['get','post'],'kayit_ekle', 'Panel::kayit_ekle');
$routes->match(['get','post'],'kayit_listele', 'Panel::kayit_listele');
$routes->get('kayit_sil/(:num)', 'Panel::kayit_sil/$1');
$routes->match(['get','post'],'kayit_duzenle/(:num)', 'Panel::kayit_duzenle/$1');

$route['order/create'] = 'order/create';
$route['order/success'] = 'order/success';
$routes->get('mongo/(:num)', 'Home::test/$1');
