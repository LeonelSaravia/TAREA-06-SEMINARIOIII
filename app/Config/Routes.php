<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//Reportes
$routes->get('/reportes/r1', 'ReporteController::getReport1');
$routes->get('/reportes/r2', 'ReporteController::getReport2');
$routes->get('/reportes/r3', 'ReporteController::getReport3');

//Muestra un interfaz web (Form) para que el usuario seleccine un "tipo de reporte" a generar
$routes->get('/reportes/showui', 'ReporteController::showUIReport');

//El formulario <select>Enviara los datos
$routes->post('/reportes/publisher', 'ReporteController::getReportByPublisher');
$routes->post('/reportes/raceAlignment', 'ReporteController::getReportByRaceAlignment');

//Dashboard
$routes->get('/dashboard/informe1', 'DashboardController::getInforme1'); 
$routes->get('/dashboard/informe2', 'DashboardController::getInforme2');
$routes->get('/dashboard/informe3', 'DashboardController::getInforme3');
$routes->get('/dashboard/informe4', 'DashboardController::getInforme4');

// Tarea 06 - Reportes Superhéroes
$routes->get('/tarea06', 'Tarea06Controller::index');
$routes->post('/tarea06/pdf', 'Tarea06Controller::generarPDF');
$routes->post('/tarea06/grafico1', 'Tarea06Controller::generarGrafico1');
$routes->get('/tarea06/grafico2', 'Tarea06Controller::generarGrafico2');
$routes->get('/tarea06/api/generos', 'Tarea06Controller::apiGeneros');
$routes->get('/tarea06/api/publishers', 'Tarea06Controller::apiPublishers');
$routes->post('/tarea06/api/superheroes-genero', 'Tarea06Controller::apiSuperheroesPorGenero');
$routes->get('/tarea06/api/peso-publisher', 'Tarea06Controller::apiPesoPublisher');

//API
$routes->get('/public/api/getdatainforme2', 'DashboardController::getDataInforme2');
$routes->get('/public/api/getdatainforme3', 'DashboardController::getDataInforme3');
$routes->get('/public/api/getdatainforme4cache', 'DashboardController::getDataInforme4Cache');
$routes->get('/public/api/getdatainforme5cache', 'DashboardController::getDataInforme5Cache');
$routes->get('/public/api/getdatainforme3cache', 'DashboardController::getDataInforme3Cache');

/* xlsx */

$routes->get('/reportes/excel1', 'ReporteController::getExcel1');