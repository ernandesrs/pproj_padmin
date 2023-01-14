<template>

        <SortableListItem @changeOrder="reorder" @deleteConfirm="deleteItem"
            v-for="item, index in theItems" :key="index" :index="index">
            <slot name="item" v-bind="{
                item: item,
                index: index
            }" />
        </SortableListItem>

</template>

<script>

import SortableListItem from './SortableListItem.vue';

export default {
    components: { SortableListItem },
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
            let targetIndexContent = {
                ...this.theItems[event.newIndex],
                order: (parseInt(event.currentIndex) + 1)
            };

            /**
             * para evitar o problema: Failed to execute 'replaceState' on 'History'
             */
            Object.entries(this.theItems[event.newIndex]).map((theItem)=>{
                this.theItems[event.newIndex][theItem[0]] = this.theItems[event.currentIndex][theItem[0]];

                this.theItems[event.currentIndex][theItem[0]] = targetIndexContent[theItem[0]];
            });
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