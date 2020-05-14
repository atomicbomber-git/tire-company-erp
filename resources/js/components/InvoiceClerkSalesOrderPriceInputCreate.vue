<template>
    <div>
        <dl>
            <dt> Customer: </dt>
            <dd> {{ m_sales_order.customer.name }} </dd>
            <dt> Created At: </dt>
            <dd> {{ dateFormat(m_sales_order.created_at) }}</dd>
            <dt> Credit Limit / Remaining Credit Limit: </dt>
            <dd>
                {{ currencyFormat(m_sales_order.customer.credit_limit) }} /
                {{ currencyFormat(m_sales_order.customer.remaining_credit_limit) }}
            </dd>
        </dl>

        <form @submit.prevent="onFormSubmit">
            <table class="table table-sm table-striped table-bordered">
                <thead class="thead thead-dark">
                <tr>
                    <th> #</th>
                    <th> Item</th>
                    <th class="text-right"> Qty. </th>
                    <th class="text-right"> Price (Rp.) </th>
                    <th class="text-right"> Subtotal (Rp.) </th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="(sales_order_item, index) in m_sales_order.sales_order_items">
                    <td> {{ index + 1 }}</td>
                    <td> {{ sales_order_item.item.name }}</td>
                    <td class="text-right"> {{ sales_order_item.quantity }}</td>
                    <td class="text-right">
                        <vue-cleave
                            class="form-control form-control-sm text-right"
                            :class="{ 'is-invalid': get(error_data, [`errors`, `sales_order_items.${index}.price`, 0], false) }"
                            v-model.number="sales_order_item.price"
                            :options="{ numeral: true }"
                        >
                        </vue-cleave>

                        <span class="invalid-feedback">
                            {{ get(error_data, [`errors`, `sales_order_items.${index}.price`, 0], false) }}
                        </span>
                    </td>
                    <td class="text-right"> {{ currencyFormat(sales_order_item.subtotal) }} </td>
                </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"> Total (Rp.): </td>
                        <td class="text-right"> {{ currencyFormat(this.total) }} </td>
                    </tr>
                </tfoot>
            </table>

            <div class="alert alert-danger"
                v-if="get(this.error_data, ['errors', 'sales_order_items', 0], false)"
            >
                <i class="fas fa-exclamation-triangle  "></i>
                {{ get(this.error_data, ["errors", "sales_order_items", 0]) }}
            </div>

            <div class="d-flex justify-content-end">
<!--                <button-->
<!--                    v-if="this.sales_order.is_approved"-->
<!--                    class="btn btn-success mr-2"-->
<!--                    @click="onMarkAsPaidButtonClick" type="button">-->
<!--                    Mark As Paid-->
<!--                </button>-->

                <button class="btn btn-primary">
                    Set Price
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
            "submit_url": String,
            "redirect_url": String,
        },

        components: {
            VueCleave: require("vue-cleave-component")
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
                return {
                    sales_order_items: this.m_sales_order.sales_order_items.map(so_item => {
                        return {
                            id: so_item.id,
                            price: so_item.price,
                        }
                    })
                }
            },
        },

        methods: {
            onMarkAsPaidButtonClick() {
                Swal.fire({
                    icon: "question",
                    titleText: 'Confirmation',
                    text: 'Do you want to proceed?',
                    showCancelButton: true,
                }).then(result => {
                    if (!result.value) { throw new Error() }
                    return axios.post(
                        `/invoice-clerk-sales-order/${this.sales_order.id}/mark-paid`
                    )
                }).then(response => {
                    window.location.replace(`/invoice-clerk-sales-order`)
                })
                .catch(error => {
                    Swal.fire({
                        icon: "error",
                        titleText: "Error",
                        text: "Invalid data",
                    })
                })
            },

            updateSubtotalAndTotal() {
                let sum = 0

                this.m_sales_order.sales_order_items.forEach(so_item => {
                    so_item.subtotal = so_item.quantity * so_item.price
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
                    return axios.post(this.submit_url, this.form_data)
                }).then(response => {
                    window.location.reload()
                })
                .catch(error => {
                    if (error.isAxiosError) {
                        this.error_data = error.response.data

                        Swal.fire({
                            icon: "error",
                            titleText: "Error",
                            text: "Invalid data",
                        })
                    }
                })
            },
        },
    }
</script>
