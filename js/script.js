document.addEventListener("DOMContentLoaded", function () {
    const regionSelect = document.getElementById("regionSelect");
    const dataOptions = document.getElementsByName("dataOption");
    const energyChartCanvas = document.getElementById("energyChart").getContext("2d");

    // Variable para almacenar la instancia del gráfico
    let chart;

    // Inicializa el gráfico según el tipo de datos
    function initializeChart(type = 'line') {
        // Destruye el gráfico anterior si existe
        if (chart) {
            chart.destroy();
        }

        // Configuración base para el gráfico
        chart = new Chart(energyChartCanvas, {
            type: type,
            data: {
                labels: [],
                datasets: []
            },
            options: {
                responsive: true,
                scales: {
                    x: { 
                        display: true, 
                        title: { display: true, text: 'Hora' },
                        grid: {
                            color: 'black', // Color de las líneas de la cuadrícula en el eje X
                        },
                        ticks: {
                            color: 'black', // Color de los números del eje X
                        }
                    },
                    y: { 
                        display: true, 
                        title: { display: true, text: type === 'line' ? 'Demanda (MW)' : 'Generación (MW)' },
                        grid: {
                            color: 'black', // Color de las líneas de la cuadrícula en el eje Y
                        },
                        ticks: {
                            color: 'black', // Color de los números del eje Y
                        }
                    }
                }
            }
        });
    }

    // Configura los datos de demanda o generación según el tipo seleccionado
    async function updateChart() {
        const regionId = regionSelect.value;
        const dataType = getSelectedDataOption();
        let apiUrl;

        // Define la URL de la API según el tipo de datos seleccionado
        if (dataType === 'demanda') {
            apiUrl = `https://api.cammesa.com/demanda-svc/demanda/ObtieneDemandaYTemperaturaRegion?id_region=${regionId}`;
            initializeChart('line');  // Inicializa un gráfico de líneas
        } else if (dataType === 'generacion') {
            apiUrl = `https://api.cammesa.com/demanda-svc/generacion/ObtieneGeneracioEnergiaPorRegion?id_region=${regionId}`;
            initializeChart('bar');   // Inicializa un gráfico de áreas apiladas
            chart.options.scales.y.stacked = true;
        }

        try {
            const response = await fetch(apiUrl);
            const data = await response.json();

            const labels = [];
            const datasetDemandaHoy = [];
            const datasetDemandaAyer = [];
            const datasetDemandaSemanaAnt = [];

            const sumtotal = [];
            const hidraulico = [];
            const termico = [];
            const renovable = [];
            const importacion = [];

            data.forEach(entry => {
                const date = new Date(entry.fecha);
                const timeLabel = `${date.getHours()}:${date.getMinutes().toString().padStart(2, '0')}`;
                labels.push(timeLabel);

                if (dataType === 'demanda') {
                    datasetDemandaHoy.push(entry.demHoy || null);
                    datasetDemandaAyer.push(entry.demAyer || null);
                    datasetDemandaSemanaAnt.push(entry.demSemanaAnt || null);
                } else if (dataType === 'generacion') {
                    sumtotal.push(entry.sumtotal || null);
                    hidraulico.push(entry.hidraulico || null);
                    termico.push(entry.termico || null);
                    renovable.push(entry.renovable || null);
                    importacion.push(entry.importacion || null);
                }
            });

            // Asigna los datasets para el tipo de gráfico seleccionado
            if (dataType === 'demanda') {
                chart.data.labels = labels;
                chart.data.datasets = [
                    { label: 'Demanda Hoy', data: datasetDemandaHoy, borderColor: 'blue', fill: false },
                    { label: 'Demanda Ayer', data: datasetDemandaAyer, borderColor: 'green', fill: false },
                    { label: 'Demanda Semana Anterior', data: datasetDemandaSemanaAnt, borderColor: 'red', fill: false },
                ];
            } else if (dataType === 'generacion') {
                chart.data.labels = labels;
                chart.data.datasets = [
                    { label: 'Sum Total', data: sumtotal, backgroundColor: 'rgba(0, 99, 132, 0.6)', fill: true },
                    { label: 'Hidráulico', data: hidraulico, backgroundColor: 'rgba(0, 200, 132, 0.6)', fill: true },
                    { label: 'Térmico', data: termico, backgroundColor: 'rgba(255, 205, 86, 0.6)', fill: true },
                    { label: 'Renovable', data: renovable, backgroundColor: 'rgba(75, 192, 192, 0.6)', fill: true },
                    { label: 'Importación', data: importacion, backgroundColor: 'rgba(153, 102, 255, 0.6)', fill: true },
                ];
            }

            chart.update();

        } catch (error) {
            console.error("Error al obtener datos de la API:", error);
        }
    }

    // Obtener el valor seleccionado de dataOption
    function getSelectedDataOption() {
        for (const option of dataOptions) {
            if (option.checked) return option.value;
        }
    }

    // Eventos para actualizar el gráfico al cambiar opciones
    regionSelect.addEventListener("change", updateChart);
    dataOptions.forEach(option => option.addEventListener("change", updateChart));

    // Carga inicial del gráfico
    updateChart();
});
