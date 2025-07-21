<template>
  <div class="analytics-container">
    <h1>Analytics Pembayaran</h1>
    <canvas id="paymentChart"></canvas>
  </div>
</template>

<script>
import { Chart } from 'chart.js';

export default {
  mounted() {
    const ctx = document.getElementById('paymentChart').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June'],
        datasets: [{
          label: 'Payment Analytics',
          data: [3000, 4000, 3500, 5000, 4500, 6000],
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true
      }
    });
  }
};
</script>

<style>
.analytics-container {
  padding: 20px;
}
canvas {
  max-width: 100%;
}
</style>

