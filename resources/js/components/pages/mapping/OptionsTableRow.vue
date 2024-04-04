<template>

    <tr class="answer-tr">
        <td class="answer-td"></td>
        <td class="answer-td">
            <input type="checkbox" @input="populate($event)" :id="`chk${question.id}_${answer.id}`"
                    :checked="question.mappedAnswerWithBehaviour.some(item => item.id === answer.id)"> &nbsp;
            <label :for="`${question.id}_${answer.id}`" class="answer-label" @click.prevent="openQuestions()">
                {{ answer.answer }}
            </label>


            <div v-show="open" class="table-responsive">
                <table class="table align-items-center table-flush table-borderless">
                    <thead class="">
                        <tr>
                            <th></th>
                            <th>Select a question that follows this answer</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr class="answer-tr">
                            <td class="answer-td"></td>
                            <td class="answer-td">

                                <label :for="`${question.id}_${answer.id}_`" class="answer-label">
                                    <input type="radio" :id="`${question.id}_${answer.id}_`"
                                        :name="`nxt${question.id}_${answer.id}`"
                                        @input="populateNextQuestion()">
                                    &nbsp;
                                    None
                                </label>

                            </td>
                        </tr>

                        <next-question-list v-for="allQuestion in allQuestions"
                            :key="`${answer.id}'_'${allQuestion.id}`" :allQuestion="allQuestion" :question="question"
                            :answer="answer" :nextQuestion="behaviour?.question_id" 
                            @populateNext="populateNextQuestion"></next-question-list>

                        <tr>
                            <td></td>
                            <td>&nbsp;</td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </td>
    </tr>


</template>

<script>
import NextQuestionList from './NextQuestionList.vue';

export default {
    components: {
        NextQuestionList
    },

    props: ["question", "answer", "answerOptions", "allQuestions"],

    data() {

        return {
            behaviour: (this.question.mappedAnswerWithBehaviour.find(item => item.id === this.answer.id))?.behaviours[0],
            open: false,
        }
    },
    methods: {
        populate(e) {
            this.$emit('populateOptions', e.target.checked, this.answer.id)
        },
        populateNextQuestion(questionId = null) {
            this.$emit('populateNextQuestion', questionId, this.answer.id)
        },
        openQuestions() {
            this.open = !this.open
        }
    }
}
</script>

<style>
.answer-label {
    cursor: pointer
}

.answer-tr,
.answer-td {
    padding: 1px !important;
    margin: 1px !important;
}
</style>