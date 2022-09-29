<template>
    <form @submit.prevent="filterFormSubmit">
        <div class="input-group">
            <input class="form-control text-center" type="search"
                v-model="filterForm.search" placeholder="Buscar por">

            <select class="form-select" name="search_on" id="search_on"
                v-model="filterForm.search_on" style="max-width:100px;">
                <option value="local">Local</option>
                <option value="all">Todos</option>
            </select>

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
                search_on: "local",
                filter: 1,
            }),
            filterResult: null,
        };
    },

    watch: {
        filterResult() {
            this.sendResult();
        }
    },

    methods: {
        filterFormSubmit() {
            let filterAction = this.$page.props?.filterAction;
            let filterResult = null;

            if (!this.filterForm.search) {
                if (this.filterResult)
                    this.filterResult = null;

                return;
            }

            if (this.filterForm.search_on === "all" && filterAction) {
                this.filterForm.get(filterAction);
                return;
            }

            let data = this.$page.props?.mainList?.data;
            if (!data || data.lenght < 1) return;

            let searchBy = this.filterForm.search;

            filterResult = data.filter((el) => {
                return el.full_name.includes(searchBy) || el.username.includes(searchBy) || el.email.includes(searchBy) ? el : null
            });

            this.filterResult = filterResult;
        },

        sendResult() {
            this.$emit("hasFiltered", this.filterResult);
        }
    },
};
</script>