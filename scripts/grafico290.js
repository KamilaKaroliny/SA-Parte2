 const ctx = document.getElementById('chartHorario').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['07:00', '14:00', '18:00', '21:00'],
      datasets: [{
        label: 'Quantidade de viagens',
        data: [200, 144, 229, 74],
        backgroundColor: [
          '#41b8d5',
          '#6ce5e8',
          '#2d8bba',
          '#2f5f98'
        ],
      }]
    }
  })
