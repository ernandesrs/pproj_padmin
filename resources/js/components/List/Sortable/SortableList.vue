<template>

    <SortingItem @changeOrder="reorder" @deleteConfirm="deleteItem"
        v-for="item, index in theItems" :key="index" :index="index">
        <slot name="item" v-bind="{
            item: item,
            index: index
        }" />
    </SortingItem>

</template>

<script>

import SortingItem from './SortingItem.vue';

export default {
    components: { SortingItem },
    props: {
        modelValue: { type: Array, default: [] }
    },
    emits: {
        'update:modelValue': null
    },
    data() {
        return {
            theItems: this.modelValue
        }
    },
    watch: {
        theItems: {
            deep: true,
            handler(nv) {
                this.$emit('update:modelValue', nv);
            }
        }
    },
    methods: {
        reorder(event) {
            let targetIndexContent = this.theItems[event.newIndex];

            this.theItems[event.newIndex] = this.theItems[event.currentIndex];
            this.theItems[event.currentIndex] = targetIndexContent;
        },
        deleteItem(event) {
            this.theItems.splice(event.currentIndex, 1);
        }
    },
    computed: {
        orders() {
            let newOrders = Object.entries(this.modelValue).map((item) => {
                return {
                    value: item[0],
                    text: (parseInt(item[0]) + 1)
                };
            });

            return newOrders;
        }
    }
}

</script>