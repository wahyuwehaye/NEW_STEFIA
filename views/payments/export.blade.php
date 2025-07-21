div class="export-container"
  h1Export Data/h1
  div class="export-options"
    labelSelect Format:/label
    select v-model="selectedFormat"
      option value="pdf"PDF/option
      option value="excel"Excel/option
    select
  div
  div
    button @click="exportData"Export/button
  div
div

script
export default {
  data() {
    return {
      selectedFormat: 'pdf'
    };
  },
  methods: {
    exportData() {
      alert(`Data will be exported as ${this.selectedFormat}!`);
    }
  }
};
/script

style
.export-container {
  padding: 20px;
}
.export-options {
  margin-bottom: 20px;
}
/style

