<template>
    <Transition enter-from-class="enter-from" enter-active-class="enter-active"
        enter-to-class="enter-to" leave-from-class="leave-from"
        leave-active-class="leave-active" leave-to-class="leave-to">
        <slot />
    </Transition>
</template>

<script>
export default {
    methods: {
    }
};
</script>

<style>
.enter-from,
.leave-to {
    opacity: 0;
}

.enter-active,
.leave-active {
    transition-duration: 0.5s;
    transition-timing-function: ease-in-out ;
}

.enter-to,
.leave-from {
    opacity: 1;
}
</style>