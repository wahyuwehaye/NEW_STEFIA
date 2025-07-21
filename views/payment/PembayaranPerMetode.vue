div class="payment-method-container"
  h1Pembayaran Per Metode/h1
  table class="method-table"
    thead
      tr
        thMetode Pembayaran/th
        thJumlah Transaksi/th
        thTotal Pembayaran/th
      tr
    thead
    tbody
      tr v-for="method in paymentMethods" :key="method.id"
        td{{ method.name }}/td
        td{{ method.transactionCount }}/td
        td{{ method.totalAmount }}/td
      tr
    tbody
  table
  div class="method-chart"
    canvas id="methodChart"/canvas
  div
div

script
import { Chart } from 'chart.js';

export default {
  data() {
    return {
      paymentMethods: [
        { id: 1, name: 'Credit Card', transactionCount: 120, totalAmount: '$24,000' },
        { id: 2, name: 'Bank Transfer', transactionCount: 90, totalAmount: '$18,000' },
      ],
    };
  },
  mounted() {
    const ctx = document.getElementById('methodChart').getContext('2d');
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: this.paymentMethods.map(method = method.name),
        datasets: [{
          data: this.paymentMethods.map(method = method.transactionCount),
          backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(54, 162, 235, 0.6)'],
          borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)'],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true
      }
    });
  }
};
/script

style
.payment-method-container {
  padding: 20px;
}
.method-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}
.method-table th, .method-table td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: left;
}
.method-table th {
  background-color: #f9f9f9;
}
.method-chart {
  max-width: 500px;
  margin: 20px auto;
}
/style

