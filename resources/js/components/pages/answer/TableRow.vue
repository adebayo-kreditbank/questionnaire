<template>
    <tr>
        <td>{{ answer.id }}</td>
        <td>{{ answer.answer }}</td>
        
        <td>{{ answer.date }}</td>
        <td>
            <a href="#" @click.prevent="$emit('editAnswer', answer)"><i class="fas fa-edit"></i></a> &nbsp;
            <a href="javascript:void(0);" data-toggle="modal" data-target="#deleteAnswerModal" style="color:coral" 
                @click="$emit('setForDeletion', answer.id)">
                <i class="fas fa-trash"></i>
            </a>
        </td>
    </tr>

</template>

<script>

export default {
    props: ["answer"],
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