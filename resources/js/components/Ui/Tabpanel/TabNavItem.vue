<template>
    <li class="nav-item" role="presentation">
        <button :class="['nav-link', { 'active': show }]" :id="name" :data-bs-toggle="$parent.navStyle"
            :data-bs-target="`#${contentName}TabPane`" type="button" role="tab"
            :aria-controls="`${name}TabPane`" :aria-selected="show">
            {{ text }}
        </button>
    </li>
</template>

<script>

export default {
    props: {
        name: { type: String, default: null },
        contentName: { type: String, default: null },
        text: { type: String, default: null },
        show: { type: Boolean, default: false },
    },
};

</script>