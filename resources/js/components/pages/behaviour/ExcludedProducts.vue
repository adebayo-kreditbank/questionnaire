<template>

    <tr class="answer-tr">
        <td class="answer-td" colspan="2">
            <label :for="`chkExc${product.id}_${behaviour.id}`" class="answer-label">
                <input type="checkbox" :id="`chkExc${product.id}_${behaviour.id}`"  @input="populate($event)" 
                    :checked="Array.isArray(behaviour.product_excluded)
                    ? behaviour.product_excluded.includes(product.id) : false"> &nbsp;
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