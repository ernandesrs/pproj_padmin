<template>

    <section>
        <div class="card card-body border-0 bg-white py-4">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-6 col-lg-4">
                    <CardUi title="Usuários" icon="users">
                        <template v-slot:content>
                            <BadgeUi :text="`Total: ${userbox.total}`" variant="primary" class="me-1" />
                            <BadgeUi :text="`Verificado: ${userbox.verified}`" variant="secondary" class="me-1" />
                            <BadgeUi :text="`Não verificado: ${userbox.unverified}`" variant="info" class="me-1" />
                        </template>
                    </CardUi>
                </div>
            </div>
        </div>
    </section>

</template>

<script>

import Layout from './../../Layouts/Panel.vue';
import CardUi from '../../Components/Ui/CardUi.vue';
import BadgeUi from '../../Components/Ui/BadgeUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { CardUi, BadgeUi },
    props: {
        userbox: { type: Object, default: {} }
    }
}
</script>