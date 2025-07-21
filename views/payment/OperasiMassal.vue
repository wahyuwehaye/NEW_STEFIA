<div class="bulk-operations-container">
    h1Operating Massal Pembayaran/h1>
    <!-- Step 1: Select File -->
    div>
      label for="fileInput">Upload CSV file:/label>
      input type="file" id="fileInput" accept=".csv">
    /div>

    <!-- Step 2: Preview and Validate -->
    div v-if="fileUploaded">
      h2Pratinjau File/h2>
      table>
        thead>
          tr>
            thNama Mahasiswa/th>
            thJumlah Pembayaran/th>
            thStatus Validasi/th
            thValidasi Error/th
          /tr>
        /thead>
        tbody>
          tr v-for="item in previewData" :key="item.id">
            td>{{ item.name }}/td>
            td>{{ item.amount }}/td>
            td{{ item.validationStatus }}/td
            td{{ item.errorDetails }}/td
          /tr>
        /tbody>
      /table>
    /div>

    <!-- Step 3: Confirmation and Execution -->
    div v-if="validationPassed">
      button @click="executeBulkOperations">Process Bulk Operations/button>
    /div>
/div>
/template>

script>
export default {
  data() {
    return {
      fileUploaded: false,
      previewData: [],
      validationPassed: false
    };
  },
  methods: {
    handleFileUpload(event) {
      // Handle file upload and parsing logic here
      this.fileUploaded = true; // Simulate file upload
      this.previewData = [
        { id: 1, name: 'John Doe', amount: '$300', validationStatus: 'Valid', errorDetails: '' },
        { id: 2, name: 'Jane Smith', amount: '$450', validationStatus: 'Invalid', errorDetails: 'Amount exceeds limit' }
      ];
      this.validationPassed = this.previewData.every(item => item.validationStatus === 'Valid');
    },
    executeBulkOperations() {
      alert('Operasi Massal Berhasil Diproses!');
    }
  }
};
/script>

style>
.bulk-operations-container {
  padding: 20px;
}
table {
  width: 100%;
  border-collapse: collapse;
}
table th, table td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: left;
}
table th {
  background-color: #f9f9f9;
}
/style>
