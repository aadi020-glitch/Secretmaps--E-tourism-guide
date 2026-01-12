// Get the canvas element
const ctx = document.getElementById('myChart').getContext('2d');

// Create the chart
const myChart = new Chart(ctx, {
    type: 'bar', // can change to 'pie' or 'doughnut'
    data: {
        labels: chartCategories, // from PHP
        datasets: [{
            label: 'Number of Destinations',
            data: chartCounts,       // from PHP
            backgroundColor: [
                'rgba(75, 192, 192, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(153, 102, 255, 0.6)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            title: { display: true, text: 'Destinations by Category' }
        },
        scales: {
            y: { beginAtZero: true, precision:0 }
        }
    }
});
