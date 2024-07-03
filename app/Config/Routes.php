<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');

//Bendahara
$routes->resource('payment', ['controller' => 'PaymentController']);

//siswa dan Wali Murid
$routes->resource('siswa', ['controller' => 'SiswaController']);

//kepala_sekolah Sekolah
$routes->resource('kepala_sekolah', ['controller' => 'KepSekController']);
