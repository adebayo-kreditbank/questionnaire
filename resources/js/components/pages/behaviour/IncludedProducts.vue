<template>

    <tr class="answer-tr">
        <td class="answer-td" colspan="2">
            <label :for="`chkInc${product.id}_${behaviour.id}`" class="answer-label">
                <input type="checkbox" :id="`chkInc${product.id}_${behaviour.id}`" @input="populate($event)"
                    :checked="Array.isArray(behaviour.product_included) 
                    ? behaviour.product_included.includes(product.id) : false"> &nbsp;
                {{ product.name }}
            </label>

        </td>
    </tr>


</template>

<script>

export default {

    props: ["behaviour", "product"],

    data() {

        return {
            open: false,
        }
    },
    methods: {
        populate(e) {
            this.$emit('populateProducts', e.target.checked, this.product.id)
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