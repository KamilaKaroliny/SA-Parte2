const ctx = document.getElementById('chartHorario').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['00:00', '00:00', '00:00', '00:00'], // 
      datasets: [{
        label: 'Qtde de viagens',
        data: [0, 1, 2, 3], // 
        backgroundColor: [
          'rgba(54, 162, 235, 0.6)',
          'rgba(54, 162, 235, 0.6)',
          'rgba(54, 162, 235, 0.6)',
          'rgba(54, 162, 235, 0.6)'
        ],
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
    }]}
    }
)
