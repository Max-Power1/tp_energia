document.addEventListener('DOMContentLoaded', () => {
    const regionSelect = document.getElementById('regionSelect');
    const demandaOption = document.getElementById('demandaOption');
    const generacionOption = document.getElementById('generacionOption');
    
    // Función para realizar la solicitud a la API
    async function fetchData() {
        const regionId = regionSelect.value;
        const isDemanda = demandaOption.checked;
        
        // Determina la URL según el tipo de dato seleccionado (demanda o generación)
        const url = isDemanda
            ? `https://api.cammesa.com/demanda-svc/demanda/ObtieneDemandaYTemperaturaRegion?id_region=${regionId}`
            : `https://api.cammesa.com/demanda-svc/generacion/ObtieneGeneracioEnergiaPorRegion?id_region=${regionId}`;
        
        try {
            const response = await fetch(url);
            const data = await response.json();
            console.log(data);  // Imprime los datos para verificar

            // Procesa los datos para Chart.js
            const processedData = processDataForChart(data, isDemanda);
            // Llama a la función para actualizar el gráfico aquí, por ejemplo: updateChart(processedData);

        } catch (error) {
            console.error('Error al obtener los datos de la API:', error);
        }
    }

    // Función para procesar los datos según el tipo (demanda o generación)
    function processDataForChart(data, isDemanda) {
        const labels = data.map(item => new Date(item.fecha).toLocaleTimeString('es-AR', {hour: '2-digit', minute: '2-digit'}));
        
        if (isDemanda) {
            // Procesa los datos de demanda
            return {
                labels,
                datasets: [
                    {
                        label: 'Demanda Hoy',
                        data: data.map(item => item.demHoy),
                        borderColor: 'rgb(75, 192, 192)',
                        fill: false,
                    },
                    {
                        label: 'Demanda Ayer',
                        data: data.map(item => item.demAyer),
                        borderColor: 'rgb(255, 99, 132)',
                        fill: false,
                    },
                    {
                        label: 'Demanda Semana Anterior',
                        data: data.map(item => item.demSemanaAnt),
                        borderColor: 'rgb(54, 162, 235)',
                        fill: false,
                    },
                    {
                        label: 'Temperatura Hoy',
                        data: data.map(item => item.tempHoy || null),  // Manejo de posibles valores nulos
                        borderColor: 'rgb(255, 205, 86)',
                        fill: false,
                        yAxisID: 'y-temp', // Para un eje secundario en Chart.js si deseas mostrar temperatura y demanda juntas
                    }
                ]
            };
        } else {
            // Procesa los datos de generación
            return {
                labels,
                datasets: [
                    {
                        label: 'Hidráulico',
                        data: data.map(item => item.hidraulico),
                        borderColor: 'rgb(75, 192, 192)',
                        fill: false,
                    },
                    {
                        label: 'Térmico',
                        data: data.map(item => item.termico),
                        borderColor: 'rgb(255, 99, 132)',
                        fill: false,
                    },
                    {
                        label: 'Nuclear',
                        data: data.map(item => item.nuclear),
                        borderColor: 'rgb(54, 162, 235)',
                        fill: false,
                    },
                    {
                        label: 'Renovable',
                        data: data.map(item => item.renovable),
                        borderColor: 'rgb(153, 102, 255)',
                        fill: false,
                    },
                    {
                        label: 'Importación',
                        data: data.map(item => item.importacion),
                        borderColor: 'rgb(201, 203, 207)',
                        fill: false,
                    }
                ]
            };
        }
    }

    // Eventos para cambios en el select y radio buttons
    regionSelect.addEventListener('change', fetchData);
    demandaOption.addEventListener('change', fetchData);
    generacionOption.addEventListener('change', fetchData);

    // Llamada inicial para cargar los datos de la selección predeterminada
    fetchData();
});
