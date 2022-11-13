<template>
    <Transition @after-enter="bounceAfterShow" enter-from-class="enter-from"
        enter-active-class="enter-active" enter-to-class="enter-to"
        leave-from-class="leave-from" leave-active-class="leave-active"
        leave-to-class="leave-to" :class="{'bounce': isShowed}">
        <slot />
    </Transition>
</template>

<script>
export default {
    data() {
        return {
            isShowed: false,
        };
    },
    methods: {
        bounceAfterShow() {
            this.isShowed = true;
            setTimeout(() => {
                this.isShowed = false;
            }, 500);
        },
    }
};
</script>

<style>
.enter-from {
    opacity: 0;
    transform: scale(1.25);
}

.leave-to {
    opacity: 0;
    transform: scale(.5) translateY(-50%);
}

.enter-active {
    transition-duration: 0.25s;
    transition-timing-function: ease-in-out;
}

.leave-active {
    transition-duration: 0.25s;
    transition-timing-function: ease-out;
}

.enter-to {
    opacity: 1;
    transform: scale(1);
}

.leave-from {
    opacity: 1;
    transform: scale(1.25);
}

.bounce {
    animation: bounce 0.5s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
    transform: translate3d(0, 0, 0);
}

@keyframes bounce {

    10%,
    90% {
        transform: translate3d(0, -1px, 0);
    }

    20%,
    80% {
        transform: translate3d(0, 2px, 0);
    }

    30%,
    50%,
    70% {
        transform: translate3d(0, -4px, 0);
    }

    40%,
    60% {
        transform: translate3d(0, 4px, 0);
    }
}
</style>