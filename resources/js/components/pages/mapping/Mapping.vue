<template>
    <!-- Container Fluid-->
    <div id="container-wrapper" class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Mapping Question with Answers</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mapping</li>
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
                                    <th>Question</th>
                                </tr>
                            </thead>

                            <tbody>

                                <table-row v-for="question in questions" :key="question.id" :question="question" :answers="answers">
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
import useValidate from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import { postRequest, getRequest, putRequest, deleteRequest } from '../../../helpers/api'
import TableRow from './TableRow.vue'

export default {
    components: {
        TableRow,
    },
    data() {
        return {
            questions: [
            ],
            answers: [
            ],
        }
    },
    created() {
        this.getQuestions()
        this.getAnswers()
    },
    methods: {
        getQuestions() {
            getRequest('admin/questions', this.form)
                .then(response => {
                    if (response.status === 200) {
                        this.questions = response.data.data;
                    }
                }).catch((error) => {
                    this.form.question = ""
                    this.errors.message = error.response.data.message ?? "invalid request"
                }).finally(() => this.isLoading = false)
        },
        getAnswers() {
            getRequest('admin/answers', this.form)
                .then(response => {
                    console.log('data from API', response.data)
                    if (response.status === 200) {
                        this.answers = response.data.data;
                    }
                }).catch((error) => {
                    this.form.answer = ""
                    this.errors.message = error.response.data.message ?? "invalid request"
                }).finally(() => this.isLoading = false)
        },
    }
}
</script>