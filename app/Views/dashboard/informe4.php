<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Informe - 4</title>

  <!--Bootstrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <button class="btn btn-outline-primary" id="obtener-datos" type="button">Obtener datos</button>
    <canvas id="lienzo"></canvas>
    <hr />
    <button class="btn btn-outline-primary" id="obtener-datos-2" type="button">Obtener datos</button>
    <canvas id="lienzo2"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
  <script>
    const lienzo = document.getElementById("lienzo");
    const lienzo2 = document.getElementById("lienzo2");
    const btnDatos = document.getElementById("obtener-datos");
    const btnDatos2 = document.getElementById("obtener-datos-2");

    let grafico1 = null;
    let grafico2 = null;

    function renderGraphic1() {
      grafico1 = new Chart(lienzo, {
        type: 'bar',
        data: {
          labels: [],
          datasets: [
            {
              label: '',
              data: []
            }
          ]
        }
      });
    }

    function renderGraphic2() {
      grafico2 = new Chart(lienzo2, {
        type: 'line',
        data: {
          labels: [],
          datasets: [
            {
              label: '',
              data: []
            }
          ]
        }
      });
    }

    btnDatos.addEventListener("click", async () => {
      try {
        const response = await fetch('<?= base_url() ?>/public/api/getdatainforme4cache', { method: 'GET' });
        if (!response.ok) {
          throw new Error('No se pudo conectar al servicio');
        }

        const data = await response.json();

        if (data.success) {
          grafico1.data.labels = data.resumen.map(row => row.gender);
          grafico1.data.datasets[0].data = data.resumen.map(row => row.total);
          grafico1.data.datasets[0].label = data.message;
          grafico1.update();
        }

      } catch (error) {
        console.error(error);
      }
    });

    btnDatos2.addEventListener("click", async () => {
      try {
        const response = await fetch('<?= base_url() ?>/public/api/getdatainforme5cache', { method: 'GET' });
        if (!response.ok) {
          throw new Error('No se pudo conectar al servicio');
        }

        const data = await response.json();

        if (data.success) {
          grafico2.data.labels = data.resumen.map(row => row.publisher_name);
          grafico2.data.datasets[0].data = data.resumen.map(row => row.total);
          grafico2.data.datasets[0].label = data.message;
          grafico2.update();
        }

      } catch (error) {
        console.error(error);
      }
    });

    renderGraphic1();
    renderGraphic2();

  </script>
</body>

</html>
