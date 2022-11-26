<template>

    <ModalUi :show="show" size="md" top>
        <div class="row py-3">
            <div class="col-12 col-md-7 mb-3">
                <div class="fs-5 fw-semibold">
                    Selecione um ícone
                </div>
            </div>

            <div class="col-12 col-md-5">
                <InputForm v-model="searchIcon" />
            </div>
        </div>

        <div v-if="icons.length" class="py-2">
            <ButtonUi @click="chooseIcon"
                v-for="name in (filtering ? filtered : icons)" :key="name" :icon="name"
                class="fs-4" :data-icon-class="$icons[name]" :data-icon-name="name" />
        </div>
        <div v-else class="mb-0 px-3 py-2 text-muted border text-center">
            Não há ícones
        </div>
    </ModalUi>
</template>

<script>

import InputForm from '../Form/InputForm.vue';
import ButtonUi from '../Ui/ButtonUi.vue';
import ModalUi from '../Ui/ModalUi.vue';

export default {
    components: { ModalUi, ButtonUi, InputForm },

    props: {
        show: { type: Boolean, default: false },
    },

    emits: {
        'iconHasChoosed': null
    },

    data() {
        return {
            searchIcon: null,
            filtering: false,
            icons: Object.keys(this.$icons),
            filtered: [],

            icon: {
                class: null,
                name: null,
            }
        }
    },

    watch: {
        searchIcon() {
            this.search();
        }
    },

    methods: {
        search() {
            if (this.searchIcon && this.searchIcon.length > 0) {
                this.filtering = true;

                this.filter();
            } else {
                this.filtering = false;
            }
        },

        filter() {
            let iconsKeys = Object.keys(this.$icons);

            this.filtered = iconsKeys.filter((iconKey) => {
                return this.$icons[iconKey].search(this.searchIcon) > -1 || iconKey.search(this.searchIcon) > -1;
            });
        },

        chooseIcon(event) {
            let data = {
                'class': event.target.getAttribute('data-icon-class', null),
                'name': event.target.getAttribute('data-icon-name', null),
            };

            this.icon.class = data.class;
            this.icon.name = data.name;

            this.emitUpdateEvent();
        },

        emitUpdateEvent() {
            this.$emit('iconHasChoosed', this.icon);
        }
    }
};

</script>