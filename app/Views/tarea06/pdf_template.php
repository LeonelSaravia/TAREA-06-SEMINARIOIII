<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?></title>
    <style>
        @page { margin: 20px; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 20px; color: #333; }
        .header { text-align: center; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 3px solid #2c3e50; }
        .header h1 { color: #2c3e50; margin: 0; font-size: 28px; }
        .header .subtitle { color: #7f8c8d; font-size: 14px; margin-top: 5px; }
        .filtros { background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 15px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid #3498db; }
        .filtros h3 { margin: 0 0 10px 0; color: #2c3e50; font-size: 16px; }
        .filtro-item { display: inline-block; margin-right: 20px; }
        .filtro-label { font-weight: bold; color: #34495e; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        th { background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%); color: white; padding: 10px; text-align: left; font-weight: 600; }
        td { padding: 8px 10px; border-bottom: 1px solid #ecf0f1; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        tr:hover { background-color: #e3f2fd; }
        .numero { text-align: center; font-weight: bold; color: #3498db; }
        .footer { text-align: center; margin-top: 30px; padding-top: 15px; border-top: 2px solid #bdc3c7; color: #7f8c8d; font-size: 11px; }
        .estadistica { background: #27ae60; color: white; padding: 3px 8px; border-radius: 12px; font-size: 10px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1><?= esc($titulo) ?></h1>
        <div class="subtitle">Reporte generado el <?= date('d/m/Y H:i:s') ?></div>
    </div>

    <div class="filtros">
        <h3>⚙️ Filtros Aplicados</h3>
        <div class="filtro-item">
            <span class="filtro-label">Género:</span> <?= esc($filtros['genero']) ?>
        </div>
        <div class="filtro-item">
            <span class="filtro-label">Límites:</span> <?= $filtros['limite_min'] ?> - <?= $filtros['limite_max'] ?>
        </div>
        <div class="filtro-item">
            <span class="filtro-label">Total:</span> <span class="estadistica"><?= $filtros['total_registros'] ?> registros</span>
        </div>
    </div>

    <?php if (!empty($superheroes)): ?>
    <table>
        <thead>
            <tr>
                <th width="30" class="numero">#</th>
                <th width="120">Superhéroe</th>
                <th width="150">Nombre Real</th>
                <th width="80">Género</th>
                <th width="100">Editorial</th>
                <th width="80">Alineación</th>
                <th width="100">Raza</th>
                <th width="40" class="numero">Int</th>
                <th width="40" class="numero">Fue</th>
                <th width="40" class="numero">Vel</th>
                <th width="50" class="numero">Altura</th>
                <th width="50" class="numero">Peso</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($superheroes as $index => $hero): ?>
            <tr>
                <td class="numero"><?= $index + 1 ?></td>
                <td><strong><?= esc($hero['superhero_name']) ?></strong></td>
                <td><?= esc($hero['full_name']) ?></td>
                <td><?= esc($hero['genero']) ?></td>
                <td><?= esc($hero['editorial']) ?></td>
                <td><?= esc($hero['alineacion']) ?></td>
                <td><?= esc($hero['raza']) ?></td>
                <td class="numero"><?= esc($hero['inteligencia']) ?></td>
                <td class="numero"><?= esc($hero['fuerza']) ?></td>
                <td class="numero"><?= esc($hero['velocidad']) ?></td>
                <td class="numero"><?= esc($hero['altura']) ?></td>
                <td class="numero"><?= esc($hero['peso']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div style="text-align: center; padding: 40px; color: #7f8c8d; border: 2px dashed #bdc3c7; border-radius: 10px;">
        <h3 style="color: #e74c3c;">⚠️ No se encontraron superhéroes</h3>
        <p>No hay registros que coincidan con los filtros aplicados.</p>
        <p>Intente ajustar los criterios de búsqueda.</p>
    </div>
    <?php endif; ?>

    <div class="footer">
        <p>Sistema de Reportes de Superhéroes | Generado automáticamente | Página 1 de 1</p>
    </div>
</body>
</html>