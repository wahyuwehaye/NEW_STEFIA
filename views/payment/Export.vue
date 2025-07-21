<template>
  <div class="export-container">
    <h1>Export Data</h1>
    <div class="export-options">
      <label>Pilih Format:</label>
      <select v-model="selectedFormat">
        <option value="pdf">PDF</option>
        <option value="excel">Excel</option>
      </select>
    </div>
    <div>
      <button @click="exportData">Export</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      selectedFormat: 'pdf'
    };
  },
  methods: {
    exportData() {
      alert(`Data akan diexport dalam format ${this.selectedFormat}!`);
    }
  }
};
</script>

<style>
.export-container {
  padding: 20px;
}
.export-options {
  margin-bottom: 20px;
}
</style>

