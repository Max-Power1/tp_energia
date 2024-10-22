<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="container bg-primary-subtle">
        <?php include './menu.php'; ?>
        <h1>Formulario para guardar datos en la base de datos</h1>

        <main>
        <!-- Tabla que será rellenada dinámicamente -->
        <table id="tablaApi" class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">idElemento</th>
                    <th scope="col">nombre</th>
                    <th scope="col">minEscala</th>
                    <th scope="col">maxEscala</th>
                    <th scope="col">idPadre</th>
                    <th scope="col">id</th>
                    <th scope="col">idRage</th>
                </tr>
            </thead>
            <tbody>
                <!-- Filas dinámicas de la tabla se insertarán aquí -->
            </tbody>
        </table>
        </main>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Script para hacer la llamada a la API y llenar la tabla -->
    <script>
        async function cargarDatos() {
            try {
                // Llamada a la API de CAMMESA
                const response = await fetch('https://api.cammesa.com/demanda-svc/demanda/RegionesDemanda');
                const data = await response.json(); // Conversión a JSON

                // Seleccionar el cuerpo de la tabla
                const tablaBody = document.querySelector('#tablaApi tbody');

                // Limpiar cualquier contenido existente
                tablaBody.innerHTML = '';

                // Recorrer los datos de la API y agregarlos a la tabla
                data.forEach((item, index) => {
                    const fila = `
                        <tr>
                            <th scope="row">${index + 1}</th>
                            <td>${item.idElemento}</td>
                            <td>${item.nombre}</td>
                            <td>${item.minEscala}</td>
                            <td>${item.maxEscala}</td>
                            <td>${item.idPadre}</td>
                            <td>${item.id}</td>
                            <td>${item.idRge ? item.idRge : 'NULL'}</td>
                        </tr>
                    `;
                    tablaBody.insertAdjacentHTML('beforeend', fila);
                });

            } catch (error) {
                console.error('Error al obtener los datos de la API:', error);
            }
        }

        // Llamar a la función para cargar los datos al cargar la página
        window.onload = cargarDatos;
    </script>
</body>
</html>
