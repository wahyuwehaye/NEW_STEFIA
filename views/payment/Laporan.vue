div class="report-container"
    h1Laporan Pembayaran/h1
    div class="filter-options"
      labelPilih Tanggal:/label
      input type="date" @change="fetchReport"
    /div
    div v-if="reportData.length"
      table class="report-table"
        thead
          tr
            thTanggal/th
            thJumlah Pembayaran/th
            thDetail/th
          /tr
        /thead
        tbody
          tr v-for="report in reportData" :key="report.id"
            td{{ report.date }}/td
            td{{ report.amount }}/td
            td{{ report.detail }}/td
          /tr
        tbody
      table
    div
  div
template

script
export default {
  data() {
    return {
      reportData: []
    };
  },
  methods: {
    fetchReport() {
      // Simulate fetch logic
      this.reportData = [
        { id: 1, date: '2025-07-20', amount: '$2,000', detail: 'Detail Pembayaran A' },
        { id: 2, date: '2025-07-21', amount: '$3,000', detail: 'Detail Pembayaran B' }
      ];
    }
  }
};
/script

style
.report-container {
  padding: 20px;
}
.report-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}
.report-table th, .report-table td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: left;
}
.report-table th {
  background-color: #f9f9f9;
}
/style
