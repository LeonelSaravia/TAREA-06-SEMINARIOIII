<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarea 06 - Reportes de Superhéroes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .card { transition: transform 0.3s ease, box-shadow 0.3s ease; border: none; border-radius: 15px; }
        .card:hover { transform: translateY(-8px); box-shadow: 0 12px 25px rgba(0,0,0,0.15); }
        .card-header { border-radius: 15px 15px 0 0 !important; font-weight: 600; }
        .btn { border-radius: 8px; font-weight: 600; transition: all 0.3s ease; }
        .btn:hover { transform: translateY(-2px); }
        .form-container { background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 25px; border-radius: 15px; }
        .feature-icon { font-size: 2rem; margin-bottom: 15px; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .gradient-bg-2 { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .gradient-bg-3 { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <!-- Header Mejorado -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-primary">🦸 Tarea 06 - Reportes de Super Hero</h1>
            <!-- <p class="lead text-muted">Leonel mejor conocido como Alss o Leo, Super poder de dormir</p> -->
        </div>
        
        <!-- PDF Report - MEJORADO -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header text-white gradient-bg">
                        <h5 class="mb-0">📊 Generar Reporte PDF</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('tarea06/pdf') ?>" method="POST" target="_blank">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Nombre del Reporte:</label>
                                    <input type="text" name="nombre_reporte" class="form-control" placeholder="Ej: Reporte de Superhéroes Marvel" value="Reporte de Superhéroes">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Género:</label>
                                    <select name="genero" class="form-select">
                                        <option value="">Todos los géneros</option>
                                        <?php foreach ($generos as $genero): ?>
                                            <option value="<?= $genero['id'] ?>"><?= esc($genero['gender']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Límite Mínimo:</label>
                                    <input type="number" name="limite_min" class="form-control" value="1" min="1" max="1000">
                                    <small class="text-muted">Desde el registro número</small>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Límite Máximo:</label>
                                    <input type="number" name="limite_max" class="form-control" value="50" min="1" max="1000">
                                    <small class="text-muted">Hasta el registro número</small>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    📄 Generar PDF
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico 1 - MEJORADO -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header text-white gradient-bg-2">
                        <h5 class="mb-0">📈 Gráfico por Distribución de Género</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('tarea06/grafico1') ?>" method="POST">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="form-label fw-bold">Seleccionar Publisher:</label>
                                    <select name="publisher" class="form-select" required>
                                        <option value="">Seleccione un publisher</option>
                                        <?php foreach ($publishers as $publisher): ?>
                                            <option value="<?= $publisher['id'] ?>"><?= esc($publisher['publisher_name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-muted">Elija una editorial para ver la distribución de géneros</small>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-success btn-lg w-100">
                                        📊 Generar Gráfico
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico 2 - CORREGIDO -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header text-white gradient-bg-3">
                        <h5 class="mb-0">⚖️ Gráfico de Pesos Promedio</h5>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <p class="mb-0 fw-bold">Promedio de peso de superhéroes por editorial</p>
                                <small class="text-muted">Ordenado de menor a mayor peso promedio</small>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="<?= base_url('tarea06/grafico2') ?>" class="btn btn-info btn-lg">
                                    📈 Ver Gráfico
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas Rápidas -->
        <div class="row mt-5">
            <div class="col-md-4 mb-3">
                <div class="card text-center bg-primary text-white">
                    <div class="card-body">
                        <div class="feature-icon">👥</div>
                        <h5>Géneros Disponibles</h5>
                        <h2><?= count($generos) ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center bg-success text-white">
                    <div class="card-body">
                        <div class="feature-icon">🏢</div>
                        <h5>Publishers</h5>
                        <h2><?= count($publishers) ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center bg-info text-white">
                    <div class="card-body">
                        <div class="feature-icon">🦸</div>
                        <h5>Reportes</h5>
                        <h2>3</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>