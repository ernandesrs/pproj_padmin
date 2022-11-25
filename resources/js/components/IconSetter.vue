<template>
    <ModalUi :show="showIconsModal" size="md" top @modalClose="showIconsModal = false">
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
            <ButtonUi @click="iconHasChoosed"
                v-for="name in (filtering ? filtered : icons)" :key="name" :icon="name"
                class="fs-4" :data-icon-class="$icons[name]" :data-icon-name="name" />
        </div>
        <div v-else class="mb-0 px-3 py-2 text-muted border text-center">
            Não há ícones
        </div>
    </ModalUi>

    <ModalUi :show="showHowItWorkModal" @modalClose="showHowItWorkModal = false">
        <h1 class="fs-4">Conheça</h1>
        <p>
            Este sistema se utiliza de uma poderosa e conhecida biblioteca de ícones,
            o <a href="https://icons.getbootstrap.com" target="_blank"
                title="Bootstrap Icons">
                Bootstrap Icons</a>! Esta biblioteca possui quase 2.000 ícones e eles
            estão todos disponíveis
            para você!
        </p>
        <h1 class="fs-4">Como inserir?</h1>
        <p>
            Para inserir um ícone é simples! Você precisa obter a tag html do ícone e
            colar no campo de ícones no formulário. Se possui dúvidas, siga os passos
            abaixo:
        </p>
        <ol>
            <li>
                Acesse <a href="https://icons.getbootstrap.com" target="_blank"
                    title="Bootstrap Icons"> https://icons.getbootstrap.com</a>
            </li>
            <li>
                Então você poderá navegar entre os milhares de ícones existentes. Você
                pode facilmente
                encontrar um ícone utilizando o campo de filtragem. Clique sobre o ícone
                escolhido.
            </li>
            <li>
                Na página do ícone à direita(em desktop) você terá diversas formas de
                obter este ícone, dentre elas a opção <strong>Icon font</strong>. Copie o
                código HTML indicado.
            </li>
            <li>
                Volte para este painel e cole o código obtido no campo
                <strong>Ícone</strong> e então <strong>salve as alterações</strong>.
            </li>
            <li>
                Pronto! Você já inseriu um ícone para o seu link ou botão.
            </li>
        </ol>
    </ModalUi>

    <div class="row">
        <div class="col-10">
            <LabelForm label="Ícone:" />
            <div class="input-group">
                <select class="form-select" @change="iconSourceChange"
                    v-model="icon.source">
                    <option selected>Origem</option>
                    <option value="local">Local</option>
                    <option value="html">HTML</option>
                </select>
                <input @input="getClassFromHtmlIcon" v-if="icon.source == 'html'"
                    type="text" class="form-control" placeholder="HTML do ícone aqui">
                <ButtonUi v-else-if="icon.source == 'local'"
                    @click="showIconsModal = true" variant="outline-primary"
                    text="Escolher ícone" />
                <div v-else class="d-flex align-items-center ps-3 t-auto">
                    Escolha uma fonte
                </div>
                <select class="form-select" v-model="icon.position">
                    <option selected>Posição</option>
                    <option value="start">Início</option>
                    <option value="end">Final</option>
                </select>
            </div>
        </div>

        <div class="col-2">
            <LabelForm label="Preview:" />
            <ButtonUi :icon="icon.name" class="ms-1">
                <template v-if="icon.class" v-slot:buttonContent>
                    <span :class="icon.class"></span>
                </template>
            </ButtonUi>
        </div>
    </div>
    <a v-if="icon.source == 'html'" @click.prevent="showHowItWorkModal = true" href="">
        <small>
            Como funciona?
        </small>
    </a>
</template>

<script>

import InputForm from './Form/InputForm.vue';
import LabelForm from './Form/LabelForm.vue';
import ButtonUi from './Ui/ButtonUi.vue';
import ModalUi from './Ui/ModalUi.vue';

export default {
    components: { ModalUi, ButtonUi, InputForm, LabelForm },

    emits: {
        'iconHasSet': null
    },

    data() {
        return {
            searchIcon: null,
            filtering: false,
            icons: Object.keys(this.$icons),
            filtered: [],

            icon: {
                source: 'local',
                class: null,
                name: null,
                position: 'start'
            },

            showHowItWorkModal: false,
            showIconsModal: false,
        }
    },

    watch: {
        searchIcon() {
            this.search();
        },

        icon: {
            deep: true,
            handler(nv, ov) {
                if (nv.position != ov.position)
                    this.emitUpdateEvent();
            }
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

        iconHasChoosed(event) {
            let data = {
                'class': event.target.getAttribute('data-icon-class', null),
                'name': event.target.getAttribute('data-icon-name', null),
            };

            this.icon.class = data.class;
            this.icon.name = data.name;

            this.showIconsModal = false;

            this.emitUpdateEvent();
        },

        getClassFromHtmlIcon(event) {
            let temp = document.createElement('div');

            if (event.target.value ?? null) {
                temp.innerHTML = event.target.value;
                this.icon.name = null;

                if (temp.firstChild instanceof Element || temp.firstChild instanceof HTMLElement) {
                    this.icon.class = temp.firstChild.getAttribute('class');
                    event.target.value = this.icon.class;
                }
            }

            this.emitUpdateEvent();
        },

        emitUpdateEvent() {
            this.$emit('iconHasSet', this.icon);
        }
    },

};

</script>