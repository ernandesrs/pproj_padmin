<template>
    <Component :is="tag" class="dropdown-item d-flex align-items-center" :href="theHref">
        <IconUi :icon="icon" class="fs-5" />
        <span :class="{'ms-2': icon && text}" v-html="text"></span>
    </Component>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue3';
import IconUi from '../IconUi.vue';

export default {
    components: { Link, IconUi },
    props: {
        text: { type: String, default: null },
        href: { type: String, default: null },
        to: { type: String, default: null },
        icon: { type: String, default: null }
    },
    computed: {
        tag() {
            if (this.to)
                return 'Link';

            return 'a';
        },

        theHref() {
            return this.href ?? this.to;
        }
    }
};

</script>