<template>

    <ButtonUi text="Opa" variant="primary" href="https://www.google.com"
        target="_blank" />

</template>

<script>

import Layout from './../../Layouts/Panel.vue';
import ButtonUi from '../../Components/Ui/ButtonUi.vue';

export default {
    components: { ButtonUi },
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,

    setup() {
        return {}
    },
}
</script>