<template>
    <Component :is="getTag" :type="getType" :class="style" :disabled="disabled"
        :href="getHref" :title="title" :target="getTarget">
        <slot v-if="$slots.buttonContent" name="buttonContent" />
        <template v-else>
            <IconUi v-if="icon" :icon="icon" />
            <span :class="{'ms-2': icon && text }">
                {{text}}
            </span>
        </template>
    </Component>
</template>

<script>

import IconUi from './IconUi.vue';
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: { IconUi, Link },
    props: {
        text: { type: String, default: null },
        variant: { type: String, default: null },
        icon: { type: String, default: null },
        size: { type: String, default: null },
        type: { type: String, default: "button" },
        disabled: { type: Boolean, default: false },
        outlined: { type: Boolean, default: false },
        customClass: { type: String, default: null },

        // 
        href: { type: String, default: null },
        to: { type: String, default: null },
        title: { type: String, default: null },
        target: { type: String, default: '_self' },
    },
    computed: {
        getType() {
            return !this.to && !this.href ? this.type : null;
        },
        getTag() {
            if (this.to)
                return 'Link';
            else if (this.href)
                return 'a';
            return 'button';
        },
        style() {
            if (this.customClass) return this.customClass;

            let bg = this.variant ? ((this.outlined ? "btn-outline-" : "btn-") + this.variant) : 'bg-transparent';
            return `btn ${this.size ? "btn-" + this.size : ""} ${bg}`;
        },
        getHref() {
            return this.href ?? (this.to ?? null);
        },
        getTarget() {
            return this.getHref ? this.target : null;
        }
    },
};

</script>