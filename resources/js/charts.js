const months = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];

function createChart(ctx, label, dataArray) {
    return new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: label,
                data: dataArray,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

const ctxVisits = document.getElementById('myChartVisits').getContext('2d');
const dataObjectVisits = JSON.parse(document.getElementById('myChartVisits').getAttribute('data-visits'));
const dataArrayVisits = Object.values(dataObjectVisits);
createChart(ctxVisits, 'Numero di visite', dataArrayVisits);

const ctxMessages = document.getElementById('myChartMessages').getContext('2d');
const dataObjectMessages = JSON.parse(document.getElementById('myChartMessages').getAttribute('data-messages'));
const dataArrayMessages = Object.values(dataObjectMessages);
createChart(ctxMessages, 'Numero di messaggi', dataArrayMessages);
