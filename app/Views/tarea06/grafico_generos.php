<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico - Distribución por Género</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Distribución de Superhéroes por Género</h1>
            <a href="<?= base_url('tarea06') ?>" class="btn btn-secondary">Volver</a>
        </div>

        <?php if ($publisher): ?>
        <div class="alert alert-info">
            <h4>Publisher seleccionado: <strong><?= esc($publisher_name) ?></strong></h4>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <canvas id="generosChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Formulario para cambiar publisher -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Cambiar Publisher</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('tarea06/grafico1') ?>" method="POST" class="row">
                    <div class="col-md-6">
                        <select name="publisher" class="form-select" required>
                            <option value="">Seleccione un publisher</option>
                            <?php foreach ($publishers as $pub): ?>
                                <option value="<?= $pub['id'] ?>" <?= $publisher == $pub['id'] ? 'selected' : '' ?>>
                                    <?= esc($pub['publisher_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success">Generar Gráfico</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formData = new FormData();
            formData.append('publisher', '<?= $publisher ?>');

            fetch('<?= base_url('tarea06/api/superheroes-genero') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const ctx = document.getElementById('generosChart').getContext('2d');
                    const chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.resumen.map(item => item.genero || 'N/A'),
                            datasets: [{
                                label: 'Cantidad de Superhéroes',
                                data: data.resumen.map(item => item.total),
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.7)',
                                    'rgba(54, 162, 235, 0.7)',
                                    'rgba(255, 206, 86, 0.7)',
                                    'rgba(75, 192, 192, 0.7)',
                                    'rgba(153, 102, 255, 0.7)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Cantidad de Superhéroes'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Género'
                                    }
                                }
                            }
                        }
                    });
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>