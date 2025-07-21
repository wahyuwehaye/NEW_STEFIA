div class="reconciliation-container"
  h1Rekonsiliasi Pembayaran/h1
  table class="reconciliation-table"
    thead
      tr
        thID Transaksi/th
        thStatus Sistem/th
        thStatus Bank/th
        thAksi/th
      tr
    thead
    tbody
      tr v-for="transaction in transactions" :key="transaction.id"
        td{{ transaction.id }}/td
        td{{ transaction.systemStatus }}/td
        td{{ transaction.bankStatus }}/td
        td
          button @click="reconcile(transaction.id)" :disabled="transaction.reconciled"
            {{ transaction.reconciled ? 'Terespons' : 'Rekonsiliasi' }}
          /button
        td
      tr
    tbody
  table
/div

script
export default {
  data() {
    return {
      transactions: [
        { id: 'TRX001', systemStatus: 'Completed', bankStatus: 'Confirmed', reconciled: true },
        { id: 'TRX002', systemStatus: 'Pending', bankStatus: 'Confirmed', reconciled: false },
      ],
    };
  },
  methods: {
    reconcile(id) {
      alert(`Rekonsiliasi transaksi ${id} berhasil!`);
      this.transactions = this.transactions.map(t =
        t.id === id ? { ...t, reconciled: true } : t
      );
    }
  }
};
/script

style
.reconciliation-container {
  padding: 20px;
}
.reconciliation-table {
  width: 100%;
  border-collapse: collapse;
}
.reconciliation-table th, .reconciliation-table td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: left;
}
.reconciliation-table th {
  background-color: #f9f9f9;
}
button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}
/style

