const ctx = document.getElementById('myChart').getContext('2d');
const charts = document.getElementById('myChart');
const dataType = charts.getAttribute('data-type');
const visitsObject = JSON.parse(charts.getAttribute('data-visits'));
const visitsArray = Object.values(visitsObject);

console.log(visitsArray);

if (dataType === 'detail') {
    const name = 'Messaggi'
    // Nota: Queste righe sono commentate perché non sono utilizzate nel tuo esempio.
    // const labels = visits.map(item => item.title);
    // const counts = visits.map(item => item.visits_count);

} else if (dataType === 'list') {
    const labels = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Numero di visite',
                data: visitsArray, // Qui sostituisci l'array di numeri con il tuo visitsArray
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