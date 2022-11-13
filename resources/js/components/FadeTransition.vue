<template>
    <Transition name="bounce">
        <slot />
    </Transition>
</template>

<script>
export default {
};
</script>

<style>
.bounce-enter-active {
    animation: bounce-in ease-out .75s;
}

.bounce-leave-active {
    animation: bounce-in ease-in-out .75s reverse;
}

@keyframes bounce-in {

    0% {
        opacity: 0;
        transform: scale(.5);
    }

    35% {
        transform: scale(1.1);
    }

    50% {
        opacity: 1;
        transform: scale(1);
    }

    55%,
    65%,
    75%,
    85% {
        transform: translate3d(0, -8px, 0);
    }

    57.5%,
    67.5%,
    77.5%,
    87.5% {
        transform: translate3d(0, 2px, 0);
    }

    60%,
    70%,
    80%,
    90% {
        transform: translate3d(0, 8px, 0);
    }

    62.5%,
    72.5%,
    82.5%,
    92.5% {
        transform: translate3d(0, -2px, 0);
    }

    100% {
        transform: translate3d(0, 0, 0);
    }
}
</style>