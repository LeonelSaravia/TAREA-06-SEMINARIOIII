<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ReporteAlignment;
use App\Models\ReporteGender;
use App\Models\ReportePublisher;

class DashboardController extends BaseController{

  //Muestra una vista
  public function getInforme1(){
    return view('dashboard/informe1');
  }

  //Mostrar una vista
  public function getInforme2(){
    return view('dashboard/informe2');
  }

  public function getInforme3(){
    return view('dashboard/informe3');
  }

  public function getInforme4(){
    return view('dashboard/informe4');
  }

  //Retorna JSON que requiere la vista
  public function getDataInforme2() {
    $this->response->setContentType('application/json');

    $data = [
      ['superhero' => "Batman",     'popularidad' => 50],
      ['superhero' => "Ben10",      'popularidad' => 10],
      ['superhero' => "Goku",       'popularidad' => 60],
      ['superhero' => "Spiderman",  'popularidad' => 15],
      ['superhero' => "Puka",       'popularidad' => 5]
    ];
    
    //En caso no encontramos datos
    if (!$data){
      return $this->response->setJSON([
        'success' => false,
        'message' => 'No encontramos super héroes',
        'resumen' => []
      ]);
    }

    sleep(3);

    //Datos encontrados, enviando JSON..
    return $this->response->setJSON( [
      'success'=> true,
      'message'=> 'Popularidad',
      'resumen' => $data
    ]);

  }

  public function getDataInforme3() {
    $this->response->setContentType(mime: 'application/json');
    $reporteAlingment = new ReporteAlignment(); //MODELO
    $data = $reporteAlingment->findAll(); //SELECT * FROM vista

    //En caso no encontramos datos
    if (!$data){
      return $this->response->setJSON([
        'success' => false,
        'message' => 'No encontramos super héroes',
        'resumen' => []
      ]);
    }

    //Datos encontrados, enviando JSON..
    return $this->response->setJSON( [
      'success'=> true,
      'message'=> 'Bandos',
      'resumen' => $data
    ]);
  }

  //Memoria caché = CPU, HDD,SOFTWARE
  public function getDataInforme3Cache() {
    $this->response->setContentType(mime: 'application/json');

    //Clave única = identificar al conjunto de datos
    $cachekey = 'resumenAlignment';

    //Obtener los datos de la memoria caché
    $data = cache($cachekey);

    if ($data == null){
      $reporteAlingment = new ReporteAlignment(); //MODELO
      $data = $reporteAlingment->findAll(); //SELECT * FROM vista

      //Escribir la nueva memoria caché
      cache()->save($cachekey, $data,3600);
    }


    //En caso no encontramos datos
    if (!$data){
      return $this->response->setJSON([
        'success' => false,
        'message' => 'No encontramos super héroes',
        'resumen' => []
      ]);
    }

    //Datos encontrados, enviando JSON..
    return $this->response->setJSON( [
      'success'=> true,
      'message'=> 'Bandos',
      'resumen' => $data
    ]);
  }

  public function getDataInforme4Cache() {
    $this->response->setContentType(mime: 'application/json');

    //Clave única = identificar al conjunto de datos
    $cachekey = 'resumenGender';

    //Obtener los datos de la memoria caché
    $data = cache($cachekey);

    if ($data == null){
      $reporteGender = new ReporteGender(); //MODELO
      $data = $reporteGender->findAll(); //SELECT * FROM vista

      //Escribir la nueva memoria caché
      cache()->save($cachekey, $data,3600);
    }


    //En caso no encontramos datos
    if (!$data){
      return $this->response->setJSON([
        'success' => false,
        'message' => 'No encontramos super héroes',
        'resumen' => []
      ]);
    }

    //Datos encontrados, enviando JSON..
    return $this->response->setJSON( [
      'success'=> true,
      'message'=> 'Genero',
      'resumen' => $data
    ]);
  }

  public function getDataInforme5Cache() {
    $this->response->setContentType(mime: 'application/json');

    //Clave única = identificar al conjunto de datos
    $cachekey = 'resumenPublisher';

    //Obtener los datos de la memoria caché
    $data = cache($cachekey);

    if ($data == null){
      $reportePublisher = new ReportePublisher(); //MODELO
      $data = $reportePublisher->findAll(); //SELECT * FROM vista

      //Escribir la nueva memoria caché
      cache()->save($cachekey, $data,3600);
    }


    //En caso no encontramos datos
    if (!$data){
      return $this->response->setJSON([
        'success' => false,
        'message' => 'No encontramos super héroes',
        'resumen' => []
      ]);
    }

    //Datos encontrados, enviando JSON..
    return $this->response->setJSON( [
      'success'=> true,
      'message'=> 'Editorial',
      'resumen' => $data
    ]);
  }

}