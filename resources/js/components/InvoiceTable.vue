<template>
    <table-lite
      :is-loading="table.isLoading"
      :columns="table.columns"
      :rows="table.rows"
      :total="table.totalRecordCount"
      :sortable="table.sortable"
      :messages="table.messages"
      @do-search="doSearch"
      @is-finished="tableLoadingFinish"
      @row-clicked="edit"
    ></table-lite>
    <div style="float: right;"><button @click="create">Dodaj</button></div>
    <InvoiceForm v-show="isFormVisible" v-bind:model="invoice" @close="close"></InvoiceForm>
  </template>
  
  <script>
  import { defineComponent, reactive, onUpdated } from "vue";
  import TableLite from "vue3-table-lite";
  import InvoiceForm from "./InvoiceForm.vue";
  import axios from "axios";
  // import VueTableLite from 'vue3-table-lite'
  
  export default defineComponent({
    name: "InvoiceTable",
    components: { TableLite, InvoiceForm },
    methods: {
      create() {
        this.invoice = {
          id: null,
          number: null,
          buyer_tin: null,
          seller_tin: null,
          product_code: null,
          net_amount: null,
          issue_date: null,
          edit_date: null
        },
        this.isFormVisible = true;
      },
      close() {
        this.isFormVisible = false;
        this.refresh();
      },
      edit(row) {
        this.invoice = self.tableData.find((element) => element.id == row.id);
        this.isFormVisible = true;
      },
      refresh() {
        this.getData();
        this.doSearch(0, 10, 'number', 'asc');
      }
    },
    data() {
      return {
        isFormVisible: false,
        invoice: {
          id: null,
          number: null,
          buyer_tin: null,
          seller_tin: null,
          product_code: null,
          net_amount: null,
          issue_date: null,
          edit_date: null
        },
      };
    },
    setup() {
      const table = reactive({
        isLoading: false,
        columns: [
          {
            label: "Nr faktury",
            field: "number",
            width: "3%",
            sortable: true,
          },
          {
            label: "NIP kupującego",
            field: "buyer_tin",
            width: "10%",
            sortable: true,
          },
          {
            label: "NIP sprzedającego",
            field: "seller_tin",
            width: "10%",
            sortable: true,
          },
          {
            label: "Nazwa produktu",
            field: "product_code",
            width: "10%",
            sortable: true,
          },
          {
            label: "Kwota netto",
            field: "net_amount",
            width: "10%",
          },
          {
            label: "Data wystawienia",
            field: "issue_date",
            width: "10%",
            sortable: true,
          },
          {
            label: "Data edycji",
            field: "edit_date",
            width: "10%",
            sortable: true,
          },
        ],
        rows: [],
        totalRecordCount: 0,
        sortable: {
          order: "id",
          sort: "asc",
        },
        messages: {
          pagingInfo: "{0}-{1} z {2}",
          pageSizeChangeLabel: "Faktury na stronie:",
          gotoPageLabel: "Do strony:",
          noDataAvailable: "Brak danych",
        }
      });

      const getData = () => {
        axios.get('api/invoices').then(response => {
            table.totalRecordCount = response.data.length;
            self.tableData = response.data;
          });
      };

      getData();
  
      const doSearch = (offset, limit, order, sort) => {
        table.isLoading = true;
        setTimeout(() => {
          table.isReSearch = offset == undefined ? true : false;
            if (offset >= 10 || limit >= table.totalRecordCount) {
              limit = table.totalRecordCount;
            }
            tableData.sort(function(a,b) {
            if (a[order] == b[order]) return 0;
              if (sort == 'asc') {    
                if(a[order] > b[order]) return 1;
                else return -1;
              } else {
                if(a[order] > b[order]) return -1;
                else return 1;
              }
            });
            
          table.rows = tableData.slice(offset, limit);
          table.sortable.order = order;
          table.sortable.sort = sort;
          
        }, 600);
      };

      doSearch(0, 10, "number", "asc");

      const tableLoadingFinish = (elements) => {
        table.isLoading = false;
        
      };

  
      return {
        table,
        getData,
        doSearch,
        tableLoadingFinish,
      };
    },

  });
  </script>