<template>
    <Transition @after-enter="endAnimation" @after-leave="endAnimation"
        :enter-from-class="enterFromLeaveToClass" enter-active-class="duration-500"
        :enter-to-class="leaveFromEnterToClass" :leave-from-class="leaveFromEnterToClass"
        leave-active-class="duration-500" :leave-to-class="enterFromLeaveToClass">
        <div
            :class="['backdrop', fixed?'position-fixed':'position-absolute', showedClass]">
            <div v-if="loading" class="loading-container">
                <div :class="spinner"></div>
                <span :class="textLoadingClass">{{textLoading}}</span>
            </div>
        </div>
    </Transition>
</template>

<script>

export default {
    name: "BackdropUi",
    data() {
        return {
            showed: false
        };
    },
    props: {
        light: { type: Boolean, default: false },
        fixed: { type: Boolean, default: false },
        loading: { type: Boolean, default: false },
        textLoading: { type: String, default: 'Aguarde...' },
    },
    methods: {
        endAnimation() {
            this.showed = !this.showed;
        },
    },
    computed: {
        enterFromLeaveToClass() {
            return `${this.light ? "backdrop-light" : "backdrop-dark"} opacity-0`;
        },
        leaveFromEnterToClass() {
            return `${this.light ? "backdrop-light" : "backdrop-dark"} opacity-75`;
        },
        showedClass() {
            if (this.showed)
                return this.leaveFromEnterToClass;
            return null;
        },
        spinner() {
            return `spinner-border ${this.light ? "text-secondary" : "text-light"}`;
        },
        textLoadingClass() {
            return `${this.light ? "text-secondary" : "text-light"} fw-semibold py-2`;
        }
    },
};

</script>

<style scoped>
.backdrop {
    width: 100%;
    height: 100%;
    z-index: 899;
    top: 0;
    left: 0;
}

.backdrop-dark {
    background-color: rgb(0, 0, 0);
}

.backdrop-light {
    background-color: rgb(255, 255, 255);
}

.loading-container {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

    animation: flashing 1s ease-in infinite both;
}

@keyframes flashing {

    0%,
    25%,
    50% {
        opacity: 0.75;
    }

    12.5%,
    75%,
    100% {
        opacity: 1;
    }
}

.duration-500 {
    transition-duration: 0.5s;
}
</style>