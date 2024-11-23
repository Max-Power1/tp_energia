document.addEventListener("DOMContentLoaded", function () {
    const regionSelect = document.getElementById("regionSelect");
    const dataOptions = document.getElementsByName("dataOption");
    const energyChart = document.getElementById("energyChart").getContext("2d");

    // Inicializa Chart.js con datos vacíos
    let chart = new Chart(energyChart, {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                { label: 'Demanda Hoy', data: [], borderColor: 'blue', fill: false },
                { label: 'Demanda Ayer', data: [], borderColor: 'green', fill: false },
                { label: 'Demanda Semana Anterior', data: [], borderColor: 'red', fill: false },
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: { display: true, title: { display: true, text: 'Hora' } },
                y: { display: true, title: { display: true, text: 'Demanda (MW)' } }
            }
        }
    });

    // Función para obtener el valor seleccionado de dataOption
    function getSelectedDataOption() {
        for (const option of dataOptions) {
            if (option.checked) return option.value;
        }
    }

    // Función para actualizar el gráfico con datos de la API
    async function updateChart() {
        const regionId = regionSelect.value;
        const dataType = getSelectedDataOption();
        let apiUrl;

        // Define la URL de la API según el tipo de datos seleccionado
        if (dataType === 'demanda') {
            apiUrl = `https://api.cammesa.com/demanda-svc/demanda/ObtieneDemandaYTemperaturaRegion?id_region=${regionId}`;
        } else if (dataType === 'generacion') {
            apiUrl = `https://api.cammesa.com/demanda-svc/generacion/ObtieneGeneracioEnergiaPorRegion?id_region=${regionId}`;
        }

        try {
            const response = await fetch(apiUrl);
            const data = await response.json();

            // Procesar y asignar los datos para el gráfico
            const labels = [];
            const demandaHoy = [];
            const demandaAyer = [];
            const demandaSemanaAnt = [];

            data.forEach(entry => {
                const date = new Date(entry.fecha);
                const timeLabel = `${date.getHours()}:${date.getMinutes().toString().padStart(2, '0')}`;
                labels.push(timeLabel);

                // Procesa datos específicos para demanda
                if (dataType === 'demanda') {
                    demandaHoy.push(entry.demHoy || null);
                    demandaAyer.push(entry.demAyer || null);
                    demandaSemanaAnt.push(entry.demSemanaAnt || null);
                }
                // Si es generación, podrías asignar otros valores según el formato de generación
            });

            // Actualiza el gráfico
            chart.data.labels = labels;
            chart.data.datasets[0].data = demandaHoy;
            chart.data.datasets[1].data = demandaAyer;
            chart.data.datasets[2].data = demandaSemanaAnt;
            chart.update();

        } catch (error) {
            console.error("Error al obtener datos de la API:", error);
        }
    }

    // Agrega eventos para actualizar el gráfico cuando cambian las opciones
    regionSelect.addEventListener("change", updateChart);
    dataOptions.forEach(option => option.addEventListener("change", updateChart));

    // Carga inicial del gráfico
    updateChart();
});
