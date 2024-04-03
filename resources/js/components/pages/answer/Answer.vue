<template>
    <!-- Container Fluid-->
    <div id="container-wrapper" class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Answer Options</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Answer</li>
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
                            <div class="form-group">
                                <label for="subtitle">Answer Option</label>
                                <textarea name="detail" class="form-control" id="detail" rows="5" maxlength="255"
                                    v-model="form.answer"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ edit.answerId ? 'Update Answer' :
                            'Submit Answer' }}</button> &nbsp; &nbsp;
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
                                    <th>Answer</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                <table-row @editAnswer="editAnswer" @setForDeletion="setAnswerToDelete"
                                    v-for="answer in answers" :key="answer.id" :answer="answer">
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

    <!-- Modal for deletion -->
    <div class="modal fade" id="deleteAnswerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
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
                    <p>Are you sure you want to delete this item {{ destroy.answerId }}?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                    <a href="#" class="btn btn-danger" data-dismiss="modal" @click.prevent="deleteAnswer()">
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
                answer: "",
            },
            edit: {
                answerId: null,
            },
            destroy: {
                answerId: null,
            },
            errors: {},
            success: {},
            answers: [
            ],
        }
    },
    created() {
        this.getAnswers()
    },
    methods: {
        reset() {
            this.edit.answerId = null
            this.form.answer = this.errors.message = this.success.message = ''
        },
        submitForm() {
            this.v$.$validate() // checks all inputs
            if (!this.v$.$error) {
                this.errors.message = ""
                return this.edit.answerId ? this.updateAnswer() : this.postAnswer()
            } else {
                this.errors.answer = !this.form.answer
            }
        },
        postAnswer() {
            postRequest('admin/answers', this.form)
                .then(response => {
                    console.log('data from API', response.data)
                    if (response.status === 200) {
                        this.form.answer = "";
                        this.success.message = response.data.message
                        this.answers = [response.data.data, ...this.answers];
                    }
                }).catch((error) => {
                    this.form.answer = ""
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
        editAnswer(answer) {
            this.form.answer = answer.answer
            this.edit.answerId = answer.id
        },
        updateAnswer() {
            putRequest('admin/answers', this.form, this.edit.answerId)
                .then(response => {
                    console.log('data from API', response.data)
                    if (response.status === 200) {
                        this.form.answer = "";
                        this.success.message = response.data.message
                        this.answers = response.data.data;
                    }
                }).catch((error) => {
                    this.form.answer = ""
                    this.errors.message = error.response.data.message ?? "invalid request"
                }).finally(() => this.isLoading = false)
        },
        setAnswerToDelete(answerId) {
            this.destroy.answerId = answerId
        },
        deleteAnswer() {
            deleteRequest('admin/answers', this.destroy.answerId)
                .then(response => {
                    console.log('data from API', response.data)
                    if (response.status === 200) {
                        this.success.message = response.data.message
                        this.answers = response.data.data;
                    }
                }).catch((error) => {
                    this.errors.message = error.response.data.message ?? "invalid request"
                }).finally(() => this.isLoading = false)
        }
    },
    validations() {
        return {
            form: {
                answer: { required }
            }
        }
    },
}
</script>