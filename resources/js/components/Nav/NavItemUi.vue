<template>
    <Component :is="theTag"
        :class="['nav-link', {'active': item.activeIn.includes($page.component)}]"
        :href="item.to ?? item.href">
        <IconUi :icon="item.icon" />
        <span :class="['text', {'ms-2': item.icon && item.text}]">{{ item.text }}</span>
    </Component>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue3';
import IconUi from '../Ui/IconUi.vue';

export default {
    components: { Link, IconUi },

    props: {
        item: { type: Object, default: {} },
        subnav: { type: Boolean, default: false }
    },

    computed: {
        theTag() {
            if (this.item.to)
                return 'Link';
            return 'a';
        }
    }
};

</script>