const ctx = document.getElementById('myChart').getContext('2d');
const charts = document.getElementById('myChart');
const visits = JSON.parse(charts.getAttribute('data-visits'));
const labels = visits.map(item => item.title);
const counts = visits.map(item => item.visits_count);

const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: '# di Visite',
            data: counts,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
            ],
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