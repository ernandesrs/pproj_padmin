<template>
    <form @submit.prevent="filterFormSubmit">
        <div class="input-group">
            <input class="form-control text-center" type="search"
                v-model="filterForm.search" placeholder="Buscar por">

            <ButtonUi icon="search" type="submit" variant="secondary" />
        </div>
    </form>
</template>

<script>

import { useForm } from '@inertiajs/inertia-vue3';
import GroupForm from './Form/GroupForm.vue';
import InputForm from './Form/InputForm.vue';
import SelectForm from './Form/SelectForm.vue';
import ButtonUi from './Ui/ButtonUi.vue';

export default {
    components: { GroupForm, InputForm, SelectForm, ButtonUi },

    data() {
        return {
            filterForm: useForm({
                search: null,
                filter: 1,
            }),
        };
    },

    watch: {
    },

    methods: {
        filterFormSubmit() {
            let filterAction = this.$page.props?.filterAction;

            if (!filterAction) {
                return;
            }

            if (!this.filterForm.search)
                window.location = filterAction;

            this.filterForm.get(filterAction);
        },
    },
};
</script>