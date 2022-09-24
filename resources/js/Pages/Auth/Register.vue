<template>

    <Head title='Criar uma conta' />

    <p>Hello, welcome to your first Inertia app!</p>

</template>
  
<script>

import Layout from './../../Layouts/Auth.vue';
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: { Head },
    layout: (h, page) => h(Layout, () => child), // Using a render function
    layout: Layout, // Using the shorthand

    props: {
        user: Object,
    },
}
</script>