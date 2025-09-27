<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>demo 01</title>
</head>
<!-- ReporteController ::getExcel1 -->
<!-- http://superhero.test/reportes/excel1 -->



<body>

<button type="button" id="exportar">Exportar</button>
  <table id="tabla-datos">
    <thead>
      <tr>
        <th>#</th>
        <th>Appelidos</th>
        <th>Nombres</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>2</td>
        <td>Pachas</td>
        <td>José</td>
      </tr>
      <tr>
        <td>3</td>
        <td>Martinez</td>
        <td>Carlos</td>
      </tr>
    </tbody>
  </table>

  <!-- use version 0.20.3 -->
  <script type="text/javascript" src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/xlsx.full.min.js"></script>
  <script>
    document.addEventListener("DO DOMContentLoadedMContentLoaded", () => {

      const btn = document.getElementById('exportar')

      btn.addEventListener("click", () => {
        //Referencia a la fuente de datos TABLA html
        const tabla = document.getElementById('tabla-datos')

        //Creae un WorkBook (Libro de trabajo) > Hoja > tabla
        const workBook = XLSX.utils.table_to_book(tabla, { sheet: 'Conatactos' })

        //Construir + habilita la descarga
        XLSX.writeFile(workBook, "Reporte.xlsx");
      })

    })

  </script>

</body>

</html>