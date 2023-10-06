const ctx = document.getElementById('myChart').getContext('2d');
const charts = document.getElementById('myChart');
const dataType = charts.getAttribute('data-type');
const dataObject = JSON.parse(charts.getAttribute('data-content'));
const dataArray = Object.values(dataObject);
const months = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];
let labels;
let label;

console.log(dataArray)

if (dataType === 'detail' || dataType === 'list') {
    labels = months;
    label = 'Numero di visite';

} else if (dataType === 'message') {
    labels = months;
    label = 'Numero di messaggi';
}

const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
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