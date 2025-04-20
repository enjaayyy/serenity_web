const ctx = document.getElementById('patient-summary-pie-chart');

function pie(labels, values){
    new Chart(ctx, {
    type: 'pie',
    data:  {
        labels: labels,
        datasets: [{
            label: 'Condition Count',
            data: values,
            borderWidth: 1
        }]
    },
    options: {
      reponsive: true,
      maintainAspectRatio: false,
    }
});
}

