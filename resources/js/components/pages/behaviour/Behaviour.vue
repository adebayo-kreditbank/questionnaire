<template>

    <!-- Container Fluid-->
    <div id="container-wrapper" class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Behaviours Logic</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Behaviours Logic</li>
            </ol>
        </div>


        <div class="row">

            <div class="col-lg-12">
                <div class="card">

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Behaviour Logic</th>
                                </tr>
                            </thead>

                            <tbody>

                                <table-row v-for="behaviour in behaviours" :key="`$tabrow${behaviour.id}`" :behaviour="behaviour"
                                    :products="products">
                                </table-row>

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>

    </div>
    <!---Container Fluid-->

</template>

<script>
import { getRequest } from '../../../helpers/api'
import TableRow from './TableRow.vue'

export default {
    components: {
        TableRow,
    },
    data() {
        return {
            behaviours: [
            ],
            products: [
            ],
        }
    },
    created() {
        this.getBehaviours()
    },
    methods: {
        getBehaviours() {
            getRequest('admin/behaviours?withProduct=true', {})
                .then(response => {
                    if (response.status === 200) {
                        this.behaviours = response.data.data.behaviours;
                        this.products = response.data.data.products;
                    }
                }).catch((error) => {
                    this.errors.message = error.response.data.message ?? "invalid request"
                }).finally(() => this.isLoading = false)
        }
    }
}
</script>