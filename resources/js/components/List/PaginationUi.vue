<template>
    <nav v-if="pages && pages.length > 3" :aria-label="label">
        <ul class="pagination justify-content-center">
            <li v-for="(page, key) in pages" :key="key"
                :class="['page-item', {'disabled active': page.active || !page.url}]">
                <Component :is="`${!page.url || page.active ? 'span':'Link'}`"
                    class="page-link"
                    :href="`${(page.url ?? null)}${urlParams ? '&' + urlParams : ''}`">
                    {{ page.label }}
                </Component>
            </li>
        </ul>
    </nav>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: { Link },
    props: {
        label: { type: String, default: "Paginação" },
        pages: { type: Array, defualt: [] },
        urlParams: { type: String, default: null }
    },
};
</script>