<div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
  <h4 class="text-sm font-medium text-gray-500 mb-4">Weekly Sales</h4>
  <canvas id="salesChart" class="w-full h-64"></canvas>
</div>
<script>
    const ctx = document.getElementById('salesChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Sales ($)',
                data: @json($chartData),
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
</script>

