<template>
    <div>
        <dl>
            <dt> Customer: </dt>
            <dd> {{ m_sales_order.customer.name }} </dd>
            <dt> Created At: </dt>
            <dd> {{ formatDate(m_sales_order.created_at) }} </dd>
        </dl>

        <form @submit.prevent="onFormSubmit">
            <table class="table table-sm table-striped table-bordered">
                <thead class="thead thead-dark">
                <tr>
                    <th> #</th>
                    <th> Item</th>
                    <th class="text-right"> Qty. </th>
                    <th class="text-right"> Price </th>
                    <th class="text-right"> Subtotal </th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="(sales_order_item, index) in m_sales_order.sales_order_items">
                    <td> {{ index + 1 }}</td>
                    <td> {{ sales_order_item.item.name }}</td>
                    <td class="text-right"> {{ sales_order_item.quantity }}</td>
                    <td class="text-right">
                        <input
                            class="form-control form-control-sm text-right"
                            v-model.number="sales_order_item.price"
                            type="number"
                            step="any"
                        >
                    </td>
                    <td class="text-right"> {{ currencyFormat(sales_order_item.subtotal) }} </td>
                </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"> Total: </td>
                        <td class="text-right"> {{ this.total }} </td>
                    </tr>
                </tfoot>
            </table>
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary">
                    Submit
                </button>
            </div>
        </form>
    </div>
</template>

<script>
    import Swal from "sweetalert2"
    import axios from "axios"

    export default {
        props: {
            "sales_order": Object,
        },
        name: "InvoiceClerkSalesOrderPriceInputCreate",

        data() {
            return {
                m_sales_order: {
                    ...this.sales_order,
                    sales_order_items: this.sales_order.sales_order_items.map(so_item => {
                        return {
                            ...so_item,
                            quantity: this.normalizeNumber(so_item.quantity),
                            price: this.normalizeNumber(so_item.price),
                            subtotal: so_item.quantity * so_item.price,
                        }
                    })
                },

                total: this.sales_order.sales_order_items.reduce((curr, next) => {
                    return curr + (next.price * next.quantity)
                }, 0)
            }
        },

        watch: {
            "m_sales_order.sales_order_items": {
                deep: true,
                handler: function() {
                    this.updateSubtotalAndTotal()
                }
            }
        },

        computed: {
            form_data() {
                return this.m_sales_order.sales_order_items.map(so_item => {
                    return {
                        id: so_item.id,
                        price: so_item.price,
                    }
                })
            },
        },

        methods: {
            updateSubtotalAndTotal() {
                let sum = 0

                this.m_sales_order.sales_order_items.forEach(so_item => {
                    so_item.subtotal = 9999
                    sum += so_item.subtotal
                })

                this.total = sum
            },

            onFormSubmit() {
                Swal.fire({
                    icon: "question",
                    titleText: 'Confirmation',
                    text: 'Do you want to proceed?',
                    showCancelButton: true,
                }).then(result => {
                    if (!result.value) { throw new Error() }

                    return axios.post('')
                })
                .catch(error => {

                })
            },
        },
    }
</script>
