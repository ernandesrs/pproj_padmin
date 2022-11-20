<template>
    <div :class="[{ 'd-flex align-items-start': horizontal && navStyle == 'pill' }]">
        <ul :class="['nav justify-content-' + navsAlignment, {
            'nav-tabs': navStyle == 'tab',
            'nav-pills': navStyle == 'pill',
            'flex-column me-3': horizontal && navStyle == 'pill',
        }]" :id="name" role="tablist">
            <slot name="tabNavs" />
        </ul>

        <div class="tab-content w-100" :id="`${name}Content`">
            <slot name="tabContents" />
        </div>
    </div>
</template>

<script>

export default {
    props: {
        name: { type: String, default: "vtab" + (new Date()).getTime() },
        pills: { type: Boolean, default: false },
        horizontal: { type: Boolean, default: false },
        navsAlignment: { type: String, default: "start" },
    },

    computed: {
        navStyle() {
            return this.pills ? "pill" : "tab";
        }
    }
};

</script>