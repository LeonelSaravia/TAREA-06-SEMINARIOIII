<?php

namespace App\Controllers;

use App\Models\Tarea06Model;

class Tarea06Controller extends BaseController
{
    public function index()
    {
        $model = new Tarea06Model();
        $data = [
            'generos' => $model->getGeneros(),
            'publishers' => $model->getPublishers()
        ];
        return view('tarea06/index', $data);
    }

    public function generarPDF()
    {
        $genero = $this->request->getPost('genero');
        $limiteMin = $this->request->getPost('limite_min');
        $limiteMax = $this->request->getPost('limite_max');
        $nombreReporte = $this->request->getPost('nombre_reporte') ?: 'Reporte de Superhéroes';

        $model = new Tarea06Model();
        $superheroes = $model->getSuperheroesPorGeneroConLimites($genero, $limiteMin, $limiteMax);
        
        // Obtener nombre del género seleccionado
        $nombreGenero = 'Todos';
        if ($genero) {
            $generos = $model->getGeneros();
            foreach ($generos as $gen) {
                if ($gen['id'] == $genero) {
                    $nombreGenero = $gen['gender'];
                    break;
                }
            }
        }

        $data = [
            'superheroes' => $superheroes,
            'titulo' => $nombreReporte,
            'filtros' => [
                'genero' => $nombreGenero,
                'limite_min' => $limiteMin,
                'limite_max' => $limiteMax,
                'total_registros' => count($superheroes)
            ]
        ];

        return view('tarea06/pdf_template', $data);
    }

    public function generarGrafico1()
    {
        $publisher = $this->request->getPost('publisher');
        
        $model = new Tarea06Model();
        $data = [
            'publisher' => $publisher,
            'publisher_name' => $model->getPublisherName($publisher),
            'publishers' => $model->getPublishers()
        ];
        
        return view('tarea06/grafico_generos', $data);
    }

    public function generarGrafico2()
    {
        return view('tarea06/grafico_pesos');
    }

    // APIs para los gráficos
    public function apiGeneros()
    {
        $this->response->setContentType('application/json');
        $model = new Tarea06Model();
        $data = $model->getConteoPorGenero();
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Conteo de superhéroes por género',
            'resumen' => $data
        ]);
    }

    public function apiPublishers()
    {
        $this->response->setContentType('application/json');
        $model = new Tarea06Model();
        $data = $model->getPublishers();
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Lista de publishers',
            'resumen' => $data
        ]);
    }

    public function apiSuperheroesPorGenero()
    {
        $this->response->setContentType('application/json');
        
        $publisher = $this->request->getPost('publisher');
        $model = new Tarea06Model();
        $data = $model->getConteoPorGeneroPublisher($publisher);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Distribución por género para publisher seleccionado',
            'resumen' => $data
        ]);
    }

    public function apiPesoPublisher()
    {
        $this->response->setContentType('application/json');
        
        $model = new Tarea06Model();
        $data = $model->getPromedioPesoPorPublisher();
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Promedio de peso por editorial',
            'resumen' => $data
        ]);
    }
}