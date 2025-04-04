<template>
    <table-lite
      :is-loading="table.isLoading"
      :columns="table.columns"
      :rows="table.rows"
      :total="table.totalRecordCount"
      :sortable="table.sortable"
      :messages="table.messages"
      @do-search="doSearch"
      @is-finished="table.isLoading = false"
    ></table-lite>
  </template>
  
  <script>
  import { defineComponent, reactive } from "vue";
  import TableLite from "vue3-table-lite";
  import axios from "axios";
  // import VueTableLite from 'vue3-table-lite'

  
  export default defineComponent({
    name: "InvoiceTable",
    components: { TableLite },
    setup() {
      // Table config
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
          {
            label: "Funkcje",
            field: "quick",
            width: "10%",
            display: function (row) {
                return (
                '<button type="button" data-id="' +
                row.id +
                '" class="is-rows-el quick-btn">Edytuj</button>&#9;&#9; ' +
                '<button type="button" data-id="' +
                row.id +
                '" class="is-rows-el quick-btn">Usuń</button>'
                );
            },
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
  
      // First get data
      getData();
  
      /**
       * Search Event
       */
      const doSearch = (offset, limit, order, sort) => {
        table.isLoading = true;
        setTimeout(() => {
          table.isReSearch = offset == undefined ? true : false;
            if (offset >= 10 || limit >= table.totalRecordCount) {
              limit = table.totalRecordCount;
            }
            console.log(tableData);
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
            
            console.log(tableData);
          table.rows = tableData.slice(offset, limit);
          table.sortable.order = order;
          table.sortable.sort = sort;
          
        }, 600);
      };

      doSearch(0, 10, "number", "asc");
  
      return {
        table,
        getData,
        doSearch,
      };
    },
  });
  </script>