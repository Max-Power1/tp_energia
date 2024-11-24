<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Licitaciones</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/demandaStyle.css">
</head>
<body>
    <div class="container Fondo-principal">
        <?php include '../drivers/menuPages.php'; ?> 

        <h1 class="text-center Titulo">Comportamiento de la Demanda de Energía Eléctrica en el MEM</h1> 
        <p class="texto-destacado text-center contenedor-ajustado">Para evaluar el comportamiento de la demanda se presenta una base completa de paso diario y se realiza un análisis sobre la base de los datos provisorios disponibles de demandas horarias a nivel de Total País, por Región, y detallando la demanda de los Grandes Usuarios del MEM (GUMA), agrupados en Ramas y Actividades características, con un seguimiento de los consumos diarios. En general se compara la demanda de los días hábiles del mes actual respecto al mes anterior y la demanda del mismo mes del año anterior y culmina con la comparación de la demanda de los últimos días vs la misma cantidad de días del mismo mes de los años anteriores, dejando la posibilidad al usuario de seleccionar los días que se desean comparar (en la base 2019 a 2023) Un punto a tener en cuenta al momento de analizar la demanda del año 2020 es el impacto que tuvo la aplicación del DNU 297/20 de Aislamiento Social Preventivo y Obligatorio (ASPO) en el consumo de energía eléctrica a partir del mes de Marzo. A partir de Noviembre 2020 comenzaron a normalizarse los consumos, cuando se pasó del Aislamiento Social Preventivo y Obligatorio (ASPO), al Distanciamiento Social, Preventivo y Obligatorio (DISPO), y cada región comenzó a autorizar en forma parcial o total distintas actividades. Los resultados son provisorios ya que se arma desde distintos sistemas de medición operativos, que se van actualizando y ajustando a medida que transcurre el mes, mejorando en cantidad y calidad de datos. A medida que avanza el mes, y especialmente al finalizar el mes de análisis, con la salida del Documento de Transacciones Económicas (DTE) se obtienen los resultados finales de cada variable, consolidándose la información.</p>

        <h2 class= "resumen-indicadores" >Resumen Indicadores 22/11/2024</h2>
        <img src=..\archivosDemanda\indicadoresImg.png alt="Imagen de indicadores" class="download-image">

        <!-- Fila de encabezado -->
        <div class="download-header">
            <div class="file-name">Nombre</div>
            <div class="file-date">Fecha Actualización</div>
            <div class="download-btn-container">Descargar Archivo</div>
        </div>
        <div class="download-row">
            <div class="file-name">Base de datos información por región</div>
            <div class="file-date">22/11/2024</div>
            <div class="download-btn-container">
                <a href="../archivosDemanda\Base de datos GU Semanal.zip" download>
                    <button class="download-btn">Descargar</button>
                </a>
            </div>
        </div>
        <div class="download-row">
            <div class="file-name">Análisis Demanda Grandes Usuarios</div>
            <div class="file-date">22/11/2024</div>
            <div class="download-btn-container">
                <a href="../archivosDemanda\Análisis Semanal Grandes Usuarios.pdf" download>
                    <button class="download-btn">Descargar</button>
                </a>
            </div>
        </div>
        <div class="download-row">
            <div class="file-name">Base Demanda Diaria 2017 2024</div>
            <div class="file-date">15/11/2024</div>
            <div class="download-btn-container">
                <a href="../archivosDemanda\Base Demanda Diaria 2017 2024.zip" download>
                    <button class="download-btn">Descargar</button>
                </a>
            </div>
        </div>
        <div class="download-row">
            <div class="file-name">EVOLUCIÓN DE LA DEMANDA POR RAMA Y ACTIVIDAD 2024 – 10</div>
            <div class="file-date">14/11/2024</div>
            <div class="download-btn-container">
                <a href="../archivosDemanda\EVOLUCIÓN DE LA DEMANDA POR RAMA Y ACTIVIDAD 2024 - 10.pdf" download>
                    <button class="download-btn">Descargar</button>
                </a>
            </div>
        </div>
        <div class="download-row">
            <div class="file-name">Demanda 2024 – 10</div>
            <div class="file-date">14/11/2024</div>
            <div class="download-btn-container">
                <a href="../archivosDemanda\Demanda 2024 - 10.pdf" download>
                    <button class="download-btn">Descargar</button>
                </a>
            </div>
        </div>
        

<!--
        <div class="download-buttons">
            <a href="archivosDemanda\Base de datos GU Semanal.zip" download>
                <button class="download-btn">Descargar Archivo 1</button>
            </a>
            <a href="archivosDemanda\Análisis Semanal Grandes Usuarios.pdf" download>
                <button class="download-btn">Descargar Archivo 2</button>
            </a>
            <a href="archivosDemanda\Base Demanda Diaria 2017 2024.zip" download>
                <button class="download-btn">Descargar Archivo 3</button>
            </a>
            <a href="archivosDemanda\Demanda 2024 - 10.pdf" download>
                <button class="download-btn">Descargar Archivo 4</button>
            </a>
            <a href="archivosDemanda\EVOLUCIÓN DE LA DEMANDA POR RAMA Y ACTIVIDAD 2024 - 10.pdf" download>
                <button class="download-btn">Descargar Archivo 5</button>
            </a>
        </div>
-->

    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
