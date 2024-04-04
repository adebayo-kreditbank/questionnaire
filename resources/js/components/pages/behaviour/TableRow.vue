<template>
    <tr>
        <td>{{ behaviour.id }}</td>
        <td>
            <h5><a href="#" class="question" @click.prevent="open = !open"> {{ behaviour.questions[0]?.question }} </a>
            </h5>

            <div v-show="open" class="table-responsive">
                <table class="table align-items-center table-flush table-borderless">
                    <thead class="">
                        <tr>
                            <th>Included Products</th>
                            <th>Excluded Products</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>

                                <div v-show="open" class="table-responsive">
                                    <table class="table align-items-center table-flush table-borderless">
                                        <thead class="">
                                            <tr>
                                                <th colspan="2">Products to include in the suggestion</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <included-products v-for="product in products"
                                                :key="`inc${behaviour.id}_${product.id}`"
                                                :product="product" :behaviour="behaviour"
                                                @populateProducts="populateIncludedProducts"></included-products>

                                            <tr>
                                                <td></td>
                                                <td>&nbsp;</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </td>
                            <td>

                                <div v-show="open" class="table-responsive">
                                    <table class="table align-items-center table-flush table-borderless">
                                        <thead class="">
                                            <tr>
                                                <th colspan="2">Products to include in the suggestion</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <excluded-products v-for="product in products"
                                                :key="`exc${behaviour.id}_${product.id}`"
                                                :product="product" :behaviour="behaviour"
                                                @populateProducts="populateExcludedProducts"></excluded-products>

                                            <tr>
                                                <td></td>
                                                <td>&nbsp;</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>


                            </td>
                        </tr>

                        <tr>
                            <td>
                                <button type="button" @click.prevent="saveProducts()" class="btn btn-primary">Save
                                    Options</button>

                                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                                    <div v-if="errors.message" class="alert alert-danger">
                                        <strong>Error!</strong> <span>{{ errors.message }}</span>
                                    </div>
                                    <div v-if="success.message" class="alert alert-success">
                                        <strong>Great!</strong> <span>{{ success.message }}</span>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </td>
    </tr>

</template>

<script>
import IncludedProducts from './IncludedProducts.vue'
import ExcludedProducts from './ExcludedProducts.vue'
import { putRequest } from '../../../helpers/api'

export default {
    components: {
        ExcludedProducts,
        IncludedProducts,
    },

    props: ["behaviour", "products"],

    data() {
        return {
            open: false,
            answerOptions: [],
            productsIncluded: Array.isArray(this.behaviour.product_included) ? this.behaviour.product_included : [],
            productsExcluded: Array.isArray(this.behaviour.product_excluded) ? this.behaviour.product_excluded : [],
            success: {},
            errors: {}
        }
    },

    methods: {
        
        populateIncludedProducts(isChecked, productId) {
            if (isChecked) {
                if (this.productsIncluded.includes(productId)) return;
                this.productsIncluded = [...this.productsIncluded, productId]
            } else {
                if (!this.productsIncluded.includes(productId)) return;
                this.productsIncluded = this.productsIncluded.filter((value, index, arr) => {
                    return value != productId
                })
            }
        },

        populateExcludedProducts(isChecked, productId) {
            if (isChecked) {
                if (this.productsExcluded.includes(productId)) return;
                this.productsExcluded = [...this.productsExcluded, productId]
            } else {
                if (!this.productsExcluded.includes(productId)) return;
                this.productsExcluded = this.productsExcluded.filter((value, index, arr) => {
                    return value != productId
                })
            }
        },
        
        saveProducts() {
            const body = { 
                product_included: this.productsIncluded.length > 0 ? this.productsIncluded : null, 
                product_excluded: this.productsExcluded.length > 0 ? this.productsExcluded : null
            }
            putRequest(`admin/behaviours/${this.behaviour.id}/products`, body)
                .then(response => {
                    if (response.status === 200) {
                        this.success.message = response.data.message
                    }
                }).catch((error) => {
                    this.errors.message = error.response.data.message ?? "invalid request"
                }).finally(() => this.isLoading = false)
        }
    }
}
</script>

<style>
td,
tr {
    font-size: 13px;
    padding: 5px;
}

.published {
    color: green
}

.unpublished {
    color: red
}

.question {
    text-decoration: none;
    color: #545454
}

.question:hover {
    text-decoration: none;
}
</style>