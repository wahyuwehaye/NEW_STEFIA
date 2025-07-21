<template>
  <div class="payment-container">
    <h1>Pembayaran Per Metode</h1>
    <table class="method-table">
      <thead>
        <tr>
          <th>Metode Pembayaran</th>
          <th>Jumlah Transaksi</th>
          <th>Total Pembayaran</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="method in paymentMethods" :key="method.id">
          <td>{{ method.name }}</td>
          <td>{{ method.transactionCount }}</td>
          <td>{{ method.totalAmount }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      paymentMethods: [
        { id: 1, name: 'Credit Card', transactionCount: 120, totalAmount: '$24,000' },
        { id: 2, name: 'Bank Transfer', transactionCount: 90, totalAmount: '$18,000' },
      ],
    };
  },
};
</script>

<style>
.payment-container {
  padding: 20px;
}
.method-table {
  width: 100%;
  border-collapse: collapse;
}
.method-table th, .method-table td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: left;
}
.method-table th {
  background-color: #f9f9f9;
}
</style>

