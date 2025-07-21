<template>
  <div class="payment-student-container">
    <h1>Pembayaran Per Mahasiswa</h1>
    <div v-for="student in students" :key="student.id" class="student-card">
      <h2>{{ student.name }}</h2>
      <p>Jumlah Piutang: {{ student.amountDue }}</p>
      <p>Status: {{ student.paymentStatus }}</p>
      <div class="actions">
        <button @click="addPayment(student.id)">Tambah Pembayaran</button>
        <button @click="sendReminder(student.id)">Kirim Pengingat</button>
        <button @click="printReceipt(student.id)">Cetak Resi</button>
      </div>
      <h3>Riwayat Pembayaran</h3>
      <ul>
        <li v-for="history in student.paymentHistory" :key="history.date">
          {{ history.date }} - {{ history.amount }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      students: [
        { id: 1, name: 'John Doe', amountDue: '$200', paymentStatus: 'Paid', paymentHistory: [{ date: '2025-01-01', amount: '$50' }] },
        { id: 2, name: 'Jane Smith', amountDue: '$150', paymentStatus: 'Pending', paymentHistory: [{ date: '2025-02-01', amount: '$30' }] },
      ],
    };
  },
  methods: {
    addPayment(studentId) {
      alert('Menambahkan pembayaran untuk mahasiswa ID ' + studentId);
    },
    sendReminder(studentId) {
      alert('Mengirim pengingat untuk mahasiswa ID ' + studentId);
    },
    printReceipt(studentId) {
      alert('Mencetak resi untuk mahasiswa ID ' + studentId);
    }
  }
};
</script>

<style>
.payment-student-container {
  padding: 20px;
}
.student-card {
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 10px;
  margin-bottom: 20px;
  transition: transform 0.3s;
}
.student-card:hover {
  transform: scale(1.02);
}
.actions {
  margin-top: 10px;
}
.actions button {
  margin-right: 8px;
}
</style>

