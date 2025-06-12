 const ctx = document.getElementById('chartHorario').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['07:00', '14:00', '18:00', '21:00'],
      datasets: [{
        label: 'Qtde de viagens',
        data: [200, 144, 229, 74],
        backgroundColor: [
          'rgba(54, 162, 235, 0.6)',
          'rgba(54, 162, 235, 0.6)',
          'rgba(54, 162, 235, 0.6)',
          'rgba(54, 162, 235, 0.6)'
        ],
      }]
    }
  })
