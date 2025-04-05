<template>
    <div class="backdrop">
        <div class="modal">
            <input type="text" hidden v-model="invoice.id"><br>
            Nr faktury
            <input type="text" required v-model="invoice.number"><br>
            NIP kupującego
            <input type="text" required v-model="invoice.buyer_tin"><br>
            NIP sprzedającego
            <input type="text" required v-model="invoice.seller_tin"><br>
            Nazwa produktu
            <input type="text" required v-model="invoice.product_code"><br>
            Kwota netto
            <input type="text" required v-model="invoice.net_amount"><br>
            Data wystawienia
            <input type="date" required v-model="invoice.issue_date"><br>
            Data edycji
            <input type="date" required v-model="invoice.edit_date"><br>
            <button class="btn-sub" @click="submit">Zapisz</button>
            <button class="btn-del" @click="destroy">Usuń</button>
            <button class="btn-cnc" @click="cancel">Anuluj</button>
        </div>
    </div>
</template>
<style>
    .backdrop {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.4);
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .modal {
        padding: 20px 20px 20px 20px;
        border: solid 2px lightblue;
        background-color: rgb(250, 250, 250);
    }
    input {
        border: 2px solid blue;
        background-color: lightcyan;
        margin: 6px;
    }
    button {
        border: 2px solid blue;
        background-color: lightcyan;
        margin: 2px;
        padding-left: 8px;
        padding-right: 8px;
    }
    button.btn-del {
        border: 2px solid red;
        background-color: lightpink;
    }
</style>
<script>
  import { computed, defineComponent } from "vue";
  import axios from "axios";
  export default defineComponent({
    name: "InvoiceForm",
    props:{
        model: {
            type: Object,
            default: () => ({}),
        }
    },
    emits: ['update:model'],
    methods: {
        submit() {
            if (this.invoice.id == undefined) {
                axios.post("api/invoices", this.invoice);
            } else {
                axios.post("api/invoices/" + this.invoice.id, this.invoice);
            }
            this.$emit('close');
        },
        cancel() {
            this.$emit('close');
        },
        destroy() {
            axios.delete("api/invoices/" + this.invoice.id);
            this.$emit('close');
        }
    },
    setup(props, {emit}) {
        const invoice = computed({
            get: () => props.model,
            set: (value) => {emit('update:model', value)},
        });
        return {invoice};
    }
  });
</script>