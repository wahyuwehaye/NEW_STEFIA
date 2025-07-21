div class="analytics-container"
  h1Analytics Pembayaran/h1
  canvas id="paymentTrendChart"/canvas
  div class="summary"
    h3Ringkasan Pembayaran/h3
    pTotal Pembayaran: {{ totalPayments }}/p
    pJumlah Transaksi: {{ totalTransactions }}/p
  div
div

script
import { Chart } from 'chart.js';

export default {
  data() {
    return {
      totalPayments: 0,
      totalTransactions: 0
    };
  },
  mounted() {
    const ctx = document.getElementById('paymentTrendChart').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
          label: 'Total Payments',
          data: [5000, 7000, 4000, 8000, 6000, 9000],
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true
      }
    });
    this.calculateSummary();
  },
  methods: {
    calculateSummary() {
      // Calculate summary
      this.totalPayments = 36000;
      this.totalTransactions = 123;
    }
  }
};
/script

style
.analytics-container {
  padding: 20px;
}
canvas {
  max-width: 100%;
  margin: auto;
}
.summary {
  margin-top: 20px;
  text-align: center;
}
/style

