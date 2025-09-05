const ctx = document.getElementById('salesChart');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
    datasets: [{
      label: 'Sales ($)',
      data: [120, 150, 180, 90, 200, 300, 250],
      borderColor: 'rgb(75, 192, 192)',
      backgroundColor: 'rgba(75, 192, 192, 0.2)',
      tension: 0.4
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { display: true } }
  }
});
