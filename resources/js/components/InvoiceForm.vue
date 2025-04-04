<template>
    Nr faktury
    <input type="text" v-model="number"><br>
    NIP kupującego
    <input type="text" v-model="buyer_tin"><br>
    NIP sprzedającego
    <input type="text" v-model="seller_tin"><br>
    Nazwa produktu
    <input type="text" v-model="product_code"><br>
    Kwota netto
    <input type="text" v-model="net_amount"><br>
    Data wystawienia
    <input type="date" v-model="issue_date"><br>
    Data edycji
    <input type="date" v-model="edit_date"><br>
    <button @click="submit">Zapisz</button>
    <button @click="cancel">Anuluj</button>
</template>
<style>
    input {
        border: 2px solid blue;
        background-color: lightcyan;
        margin: 6px;
    }
    button {
        border: 2px solid blue;
        background-color: lightcyan;
        margin: 6px;
        padding-left: 8px;
        padding-right: 8px;
    }
</style>
<script>
  import { defineComponent, reactive } from "vue";
  export default defineComponent({
    name: "InvoiceForm",
  });
</script>