<template>
    <tr>
        <td>{{ question.id }}</td>
        <td>
            <h4><a href="#" class="question" @click.prevent="open = !open"> {{ question.question }} </a></h4>

            <div v-show="open" class="table-responsive">
                <table class="table align-items-center table-flush table-borderless">
                    <thead class="">
                        <tr>
                            <th>Answer Options</th>
                        </tr>
                    </thead>

                    <tbody>

                        <options-table-row v-for="answer in answers" :key="`${question.id}'_'${answer.id}`"
                            :answer="answer" :question="question" :answerOptions="answerOptions"
                            :allQuestions="allQuestions" @populateOptions="populateOptions"
                            @populateNextQuestion="populateNextQuestion">
                        </options-table-row>

                        <tr>
                            <td></td>
                            <td>
                                <button type="button" @click.prevent="saveOptions()" class="btn btn-primary">Save
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
import OptionsTableRow from './OptionsTableRow.vue'
import { postRequest } from '../../../helpers/api'

export default {
    components: {
        OptionsTableRow,
    },

    props: ["question", "answers", "allQuestions"],

    data() {
        return {
            open: false,
            answerOptions: this.question.mappedAnswers,
            nextQuestions: { "0": null },
            success: {},
            errors: {}
        }
    },

    methods: {
        populateOptions(isChecked, answerId) {
            if (isChecked) {
                if (this.answerOptions.includes(answerId)) return;
                this.answerOptions = [...this.answerOptions, answerId]
            } else {
                if (!this.answerOptions.includes(answerId)) return;
                this.answerOptions = this.answerOptions.filter((value, index, arr) => {
                    return value != answerId
                })
            }
        },
        populateNextQuestion(questionId, answerId) {
            // this.nextQuestions = [ ...this.nextQuestions, { answerId: answerId, questionId: questionId }]
            this.nextQuestions[JSON.stringify(answerId)] = questionId
            console.log(this.nextQuestions)
        },
        saveOptions() {
            const body = { answerOptions: this.answerOptions, nextQuestions: this.nextQuestions }
            postRequest(`admin/mappings/questions/${this.question.id}/answers`, body)
                .then(response => {
                    console.log('data from API', response.data)
                    if (response.status === 200) {
                        this.success.message = response.data.message
                        this.answerOptions = response.data.data;
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