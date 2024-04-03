<template>
    <tr>
        <td>{{ question.id }}</td>
        <td>{{ question.question }}</td>
        <td>{{ question.parentQuestionId }}</td>
        <td>
            <a href="#" :class="question.isPublished ? 'published' : 'unpublished' " @click.prevent="$emit('setForPublish', question)">
            {{ question.isPublished == false ? 'publish' : 'unpublish' }}</a>
        </td>
        
        <td>{{ question.date }}</td>
        <td>
            <a href="#" @click.prevent="$emit('editQuestion', question)"><i class="fas fa-edit"></i></a> &nbsp;
            <a href="javascript:void(0);" data-toggle="modal" data-target="#deleteModal" style="color:coral" 
                @click="$emit('setForDeletion', question.id)">
                <i class="fas fa-trash"></i>
            </a>
        </td>
    </tr>

</template>

<script>

export default {
    props: ["question"],

    data() {
        return {
            questionId: null
        }
    },
}
</script>

<style>
td, tr {
    font-size: 13px; 
    padding: 5px;
}
.published {
    color: green
}
.unpublished {
    color: red
}
</style>