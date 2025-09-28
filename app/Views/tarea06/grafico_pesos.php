<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico - Promedio de Peso por Editorial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .chart-container { position: relative; height: 70vh; width: 100%; }
    </style>
</head>
<body>
    <div class="container py-4">
        <!-- Header Mejorado -->
        <div class="card mb-4 bg-white">
            <div class="card-body text-center py-4">
                <h1 class="display-5 fw-bold text-primary mb-2">⚖️ Promedio de Peso por Editorial</h1>
                <!-- <p class="lead text-muted mb-0">Análisis comparativo del peso promedio de superhéroes por editorial</p> -->
                <div class="mt-3">
                    <span class="badge bg-info fs-6">Ordenado de menor a mayor</span>
                </div>
            </div>
        </div>

        <!-- Controles -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">📊 Gráfico de Pesos Promedio</h5>
                        <small class="text-muted">Datos en tiempo real desde la base de datos</small>
                    </div>
                    <div>
                        <a href="<?= base_url('tarea06') ?>" class="btn btn-outline-primary">
                            ← Volver al Inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico -->
        <div class="card">
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="pesosChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Loading -->
        <div id="loading" class="text-center mt-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando datos...</span>
            </div>
            <p class="mt-2 text-muted">Cargando datos del gráfico...</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadingElement = document.getElementById('loading');
            
            fetch('<?= base_url('tarea06/api/peso-publisher') ?>')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.resumen.length > 0) {
                        // Ocultar loading
                        loadingElement.style.display = 'none';
                        
                        const ctx = document.getElementById('pesosChart').getContext('2d');
                        
                        // Preparar datos
                        const labels = data.resumen.map(item => item.editorial || 'N/A');
                        const pesos = data.resumen.map(item => parseFloat(item.promedio_peso) || 0);
                        const cantidades = data.resumen.map(item => item.total_superheroes || 0);
                        
                        // Colores dinámicos
                        const backgroundColors = pesos.map((peso, index) => {
                            const hue = (index * 137.5) % 360; // Distribución uniforme de colores
                            return `hsla(${hue}, 70%, 65%, 0.7)`;
                        });
                        
                        const borderColors = backgroundColors.map(color => color.replace('0.7', '1'));
                        
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Peso Promedio (kg)',
                                    data: pesos,
                                    backgroundColor: backgroundColors,
                                    borderColor: borderColors,
                                    borderWidth: 2,
                                    borderRadius: 5,
                                    borderSkipped: false,
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                indexAxis: 'y',
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Peso Promedio (kg)',
                                            font: {
                                                size: 14,
                                                weight: 'bold'
                                            }
                                        },
                                        grid: {
                                            color: 'rgba(0,0,0,0.1)'
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Editoriales',
                                            font: {
                                                size: 14,
                                                weight: 'bold'
                                            }
                                        },
                                        grid: {
                                            color: 'rgba(0,0,0,0.1)'
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'top',
                                        labels: {
                                            font: {
                                                size: 12
                                            }
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            afterLabel: function(context) {
                                                const index = context.dataIndex;
                                                return `Cantidad: ${cantidades[index]} superhéroes`;
                                            }
                                        }
                                    }
                                },
                                animation: {
                                    duration: 2000,
                                    easing: 'easeOutQuart'
                                }
                            }
                        });
                    } else {
                        loadingElement.innerHTML = `
                            <div class="alert alert-warning">
                                <h4>⚠️ No hay datos disponibles</h4>
                                <p>No se encontraron datos para mostrar el gráfico.</p>
                                <a href="<?= base_url('tarea06') ?>" class="btn btn-primary">Volver al Inicio</a>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    loadingElement.innerHTML = `
                        <div class="alert alert-danger">
                            <h4>❌ Error al cargar los datos</h4>
                            <p>No se pudo conectar con el servidor. Intente nuevamente.</p>
                            <a href="<?= base_url('tarea06') ?>" class="btn btn-primary">Volver al Inicio</a>
                        </div>
                    `;
                });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>