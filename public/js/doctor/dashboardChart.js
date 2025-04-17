const ctx = document.getElementById('patient-summary-pie-chart');

function pie(){
    new Chart(ctx, {
    type: 'pie',
    data:  {
        labels:['red', 'blue'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
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

