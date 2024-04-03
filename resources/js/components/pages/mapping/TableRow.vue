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

                        <set-up-table-row 
                            v-for="answer in answers" 
                            :key="`${question.id}'_'${answer.id}`" 
                            :answer="answer" 
                            :question="question"
                            @answerOption="populateOptions">
                        </set-up-table-row>

                    </tbody>
                </table>
            </div>

        </td>
    </tr>

</template>

<script>
import SetUpTableRow from './SetUpTableRow.vue'

export default {
    components: {
        SetUpTableRow,
    },

    props: ["question","answers"],

    data() {
        return {
            open: false,
            questionAnswerOptions: []
        }
    },

    methods: {
        populateOptions(answerId) {
            alert("Hey, " + answerId)
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