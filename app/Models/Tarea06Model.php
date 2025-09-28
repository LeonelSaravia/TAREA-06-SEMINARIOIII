<?php

namespace App\Models;

use CodeIgniter\Model;

class Tarea06Model extends Model
{
    protected $table = 'superhero';
    protected $primaryKey = 'id';
    protected $allowedFields = ['superhero_name', 'full_name', 'gender_id', 'publisher_id', 'height_cm', 'weight_kg'];

    public function getGeneros()
    {
        return $this->db->table('gender')
            ->select('id, gender')
            ->orderBy('gender', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getPublishers()
    {
        return $this->db->table('publisher')
            ->select('id, publisher_name')
            ->where('publisher_name !=', '')
            ->orderBy('publisher_name', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getPublisherName($publisher_id)
    {
        if (!$publisher_id) return 'Todos los Publishers';
        
        $result = $this->db->table('publisher')
            ->select('publisher_name')
            ->where('id', $publisher_id)
            ->get()
            ->getRowArray();
        
        return $result ? $result['publisher_name'] : 'Desconocido';
    }

    public function getSuperheroesPorGeneroConLimites($genero_id = null, $limiteMin = 10, $limiteMax = 100)
    {
        $query = $this->select('
                sh.superhero_name,
                sh.full_name,
                g.gender as genero,
                p.publisher_name as editorial,
                a.alignment as alineacion,
                r.race as raza,
                ha1.attribute_value as inteligencia,
                ha2.attribute_value as fuerza,
                ha3.attribute_value as velocidad,
                sh.height_cm as altura,
                sh.weight_kg as peso
            ')
            ->from('superhero sh', true)
            ->join('gender g', 'g.id = sh.gender_id', 'left')
            ->join('publisher p', 'p.id = sh.publisher_id', 'left')
            ->join('alignment a', 'a.id = sh.alignment_id', 'left')
            ->join('race r', 'r.id = sh.race_id', 'left')
            ->join('hero_attribute ha1', 'ha1.hero_id = sh.id AND ha1.attribute_id = 1', 'left')
            ->join('hero_attribute ha2', 'ha2.hero_id = sh.id AND ha2.attribute_id = 2', 'left')
            ->join('hero_attribute ha3', 'ha3.hero_id = sh.id AND ha3.attribute_id = 3', 'left')
            ->orderBy('sh.superhero_name', 'ASC');

        if ($genero_id) {
            $query->where('sh.gender_id', $genero_id);
        }

        $result = $query->findAll();

        // Aplicar límites si se especifican
        if ($limiteMin && $limiteMax) {
            $start = max(0, $limiteMin - 1);
            $length = min($limiteMax - $limiteMin + 1, count($result) - $start);
            if ($length > 0) {
                $result = array_slice($result, $start, $length);
            } else {
                $result = [];
            }
        }

        return $result;
    }

    public function getConteoPorGenero()
    {
        return $this->select('
                g.gender as genero,
                COUNT(sh.id) as total
            ')
            ->from('superhero sh', true)
            ->join('gender g', 'g.id = sh.gender_id', 'left')
            ->groupBy('sh.gender_id, g.gender')
            ->orderBy('total', 'DESC')
            ->findAll();
    }

    public function getConteoPorGeneroPublisher($publisher_id = null)
    {
        $query = $this->select('
                g.gender as genero,
                COUNT(sh.id) as total
            ')
            ->from('superhero sh', true)
            ->join('gender g', 'g.id = sh.gender_id', 'left')
            ->groupBy('sh.gender_id, g.gender');

        if ($publisher_id) {
            $query->where('sh.publisher_id', $publisher_id);
        }

        return $query->orderBy('total', 'DESC')->findAll();
    }

    public function getPromedioPesoPorPublisher()
    {
        $result = $this->select('
                p.publisher_name as editorial,
                ROUND(AVG(sh.weight_kg), 2) as promedio_peso,
                COUNT(sh.id) as total_superheroes
            ')
            ->from('superhero sh', true)
            ->join('publisher p', 'p.id = sh.publisher_id', 'left')
            ->where('sh.weight_kg IS NOT NULL')
            ->where('sh.weight_kg > 0')
            ->where('p.publisher_name !=', '')
            ->groupBy('sh.publisher_id, p.publisher_name')
            ->orderBy('promedio_peso', 'ASC')
            ->findAll();

        // Filtrar resultados nulos o vacíos
        return array_filter($result, function($item) {
            return !empty($item['editorial']) && $item['promedio_peso'] > 0;
        });
    }
}