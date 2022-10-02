<template>

    <div @mouseover="hover=true" @mouseout="hover=false" :class="cardStyle">
        <div v-if="icon" :class="iconCardStyle">
            <IconUi :icon="icon" />
        </div>
        <div :class="{'ms-2': icon}">
            <h2 v-if="title" v-html="title" class="fs-5 fw-semibold mb-1"></h2>
            <div v-if="$slots.content">
                <slot name="content" />
            </div>
        </div>
    </div>
</template>

<script>

import IconUi from './IconUi.vue';

export default {
    components: { IconUi },
    props: {
        icon: { type: String, default: null },
        title: { type: String, default: null },
        border: { type: Boolean, default: false },
        noShadow: { type: Boolean, default: false },
    },

    data() {
        return {
            hover: false
        };
    },

    computed: {
        iconCardStyle() {
            return `d-flex justify-content-center align-items-center fs-1 bg-dark text-light rounded icon-card`;
        },
        cardStyle() {
            return `card card-body ${!this.border ? 'border-0' : ''} ${this.noShadow ? '' : 'shadow-sm'} ${this.hover ? 'shadow-lg' : ''} flex-row justify-content-center align-items-center`;
        }
    }
};

</script>

<style>
.icon-card {
    min-width: 50px;
    min-height: 50px;
}

@media(min-width:768px) {
    .icon-card {
        min-width: 75px;
        min-height: 75px;
    }
}
</style>