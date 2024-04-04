<template>

    <tr class="answer-tr">
        <td class="answer-td"></td>
        <td class="answer-td">

            <label :for="`${question.id}_${answer.id}_${allQuestion.id}`" class="answer-label">
                <input type="radio" :id="`${question.id}_${answer.id}_${allQuestion.id}`" 
                    :name="`nxt${question.id}_${answer.id}`" :checked="selected" @input="parseSelection($event)">
                &nbsp;
                {{ allQuestion.question }}
            </label>

        </td>
    </tr>

</template>

<script>

export default {
    props: ["allQuestion", "question", "answer", "nextQuestion"],
    data() {
        return {
            selected: this.allQuestion.id == this.nextQuestion
        }
    },
    methods: {
        parseSelection(e) {
            // alert(e.target.checked)
            this.$emit('populateNext', this.allQuestion.id)

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