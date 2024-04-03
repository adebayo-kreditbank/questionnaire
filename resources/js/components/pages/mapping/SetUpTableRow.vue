<template>

    <tr class="answer-tr">
        <td class="answer-td"></td>
        <td class="answer-td">
            <label :for="`${question.id}'_'${answer.id}`" class="answer-label">
                <input @change="$emit('answerOption', answer.id)" type="checkbox" :id="`${question.id}'_'${answer.id}`"> &nbsp;
                {{ answer.answer }}
            </label>
        </td>
    </tr>


</template>

<script>

export default {
    props: ["question", "answer"],
}
</script>

<style>
.answer-label {
    cursor: pointer
}
.answer-tr, .answer-td {
    padding: 1px !important;
    margin: 1px !important;
}
</style>