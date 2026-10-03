<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Pages::home');
$routes->get('tasks', 'Tasks::index');
$routes->get('profile', 'Profile::index');
$routes->get('about', 'Pages::about');
$routes->get('coffeehouse', 'Pages::coffeehouse');
$routes->get('coffeehouse/about', 'Pages::coffeehouseAbout');
$routes->get('customers', 'Customers::index');
$routes->get('users', 'Users::index');
