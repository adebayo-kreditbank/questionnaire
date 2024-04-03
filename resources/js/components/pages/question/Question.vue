<template>
    <!-- Container Fluid-->
    <div id="container-wrapper" class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Question</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Question</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <!-- Form Basic -->
                <div class="card mb-4" id="heroFormSection">
                    <div class="card-header d-flex flex-row align-items-center justify-content-between">
                        <div v-if="errors.message" class="alert alert-danger">
                            <strong>Error!</strong> <span>{{ errors.message }}</span>
                        </div>
                        <div v-if="success.message" class="alert alert-success">
                            <strong>Great!</strong> <span>{{ success.message }}</span>
                        </div>
                    </div>

                    <div class="card-body">

                        <form method="POST" @submit.prevent="submitForm()">

                            <input type="hidden" name="page_content_id" id="page_content_id">
                            <!-- <div class="form-group">
                                <label for="about_page">Parent Question</label>
                                <select class="select2-single-placeholder form-control" value=""
                                    v-model="form.parent_question_id">
                                    <option value="">Select Question</option>
                                    <option value=""></option>
                                </select>
                            </div> -->
                            <!-- <div class="form-group">
                                <label for="title">Question</label>
                                <input type="text" class="form-control" name="title" id="title"
                                    aria-describedby="emailHelp" placeholder="Enter Title" value="">
                                <small id="emailHelp" class="form-text text-muted">Title of the section</small>
                            </div> -->
                            <div class="form-group">
                                <label for="subtitle">Question</label>
                                <textarea name="detail" class="form-control" id="detail" rows="5" maxlength="255"
                                    v-model="form.question"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ edit.questionId ? 'Update Question' :
                            'Submit Question' }}</button> &nbsp; &nbsp;
                            <button type="reset" class="btn btn-default" @click.prevent="reset()">Reset</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Question</th>
                                    <th>Parent</th>
                                    <th>Publish</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                <table-row @editQuestion="editQuestion" @setForDeletion="setQuestionToDelete" @setForPublish="publish"
                                    v-for="question in questions" :key="question.id" :question="question">
                                </table-row>

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>

        <!-- <div class="row">
            <div class="col-lg-12 mb-4">
                
            </div>
        </div> -->

    </div>
    <!---Container Fluid-->

    <!-- Modal for deletion -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelLogout">Hey!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this item {{ destroy.questionId }}?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                    <a href="#" class="btn btn-danger" data-dismiss="modal" @click.prevent="deleteQuestion()">
                        Delete</a>
                </div>
            </div>
        </div>
    </div>

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
            v$: useValidate(),
            form: {
                question: "",
                parent_question_id: null,
                is_published: false,
            },
            edit: {
                questionId: null,
            },
            destroy: {
                questionId: null,
            },
            errors: {},
            success: {},
            questions: [
            ],
        }
    },
    created() {
        this.getQuestions()
    },
    methods: {
        reset() {
            this.edit.questionId = this.form.parent_question_id = null
            this.form.question = this.errors.message = this.success.message = ''
        },
        submitForm() {
            this.v$.$validate() // checks all inputs
            if (!this.v$.$error) {
                this.errors.message = ""
                return this.edit.questionId ? this.updateQuestion() : this.postQuestion()
            } else {
                this.errors.question = !this.form.question
            }
        },
        postQuestion() {
            postRequest('admin/questions', this.form)
                .then(response => {
                    console.log('data from API', response.data)
                    if (response.status === 200) {
                        this.form.question = "";
                        this.success.message = response.data.message
                        this.questions = [response.data.data, ...this.questions];
                    }
                }).catch((error) => {
                    this.form.question = ""
                    this.errors.message = error.response.data.message ?? "invalid request"
                }).finally(() => this.isLoading = false)
        },
        getQuestions() {
            getRequest('admin/questions', this.form)
                .then(response => {
                    console.log('data from API', response.data)
                    if (response.status === 200) {
                        this.questions = response.data.data;
                    }
                }).catch((error) => {
                    this.form.question = ""
                    this.errors.message = error.response.data.message ?? "invalid request"
                }).finally(() => this.isLoading = false)
        },
        editQuestion(question) {
            this.form.question = question.question
            this.parent_question_id = question.parentQuestionId
            this.edit.questionId = question.id
        },
        updateQuestion() {
            putRequest('admin/questions', this.form, this.edit.questionId)
                .then(response => {
                    console.log('data from API', response.data)
                    if (response.status === 200) {
                        this.form.question = "";
                        this.success.message = response.data.message
                        this.questions = response.data.data;
                    }
                }).catch((error) => {
                    this.form.question = ""
                    this.errors.message = error.response.data.message ?? "invalid request"
                }).finally(() => this.isLoading = false)
        },
        setQuestionToDelete(questionId) {
            this.destroy.questionId = questionId
        },
        deleteQuestion() {
            deleteRequest('admin/questions', this.destroy.questionId)
                .then(response => {
                    console.log('data from API', response.data)
                    if (response.status === 200) {
                        this.success.message = response.data.message
                        this.questions = response.data.data;
                    }
                }).catch((error) => {
                    this.errors.message = error.response.data.message ?? "invalid request"
                }).finally(() => this.isLoading = false)
        },
        publish(question) {
            putRequest('admin/questions', { question: question.question, is_published: !question.isPublished }, question.id)
                .then(response => {
                    console.log('data from API', response.data)
                    if (response.status === 200) {
                        this.form.question = "";
                        this.success.message = `Question ${question.id} publish status updated!`
                        this.questions = response.data.data;
                    }
                }).catch((error) => {
                    this.form.question = ""
                    this.errors.message = error.response.data.message ?? "invalid request"
                }).finally(() => this.isLoading = false)
        }
    },
    validations() {
        return {
            form: {
                question: { required },
                parent_question_id: {},
                is_published: {},
            }
        }
    },
}
</script>