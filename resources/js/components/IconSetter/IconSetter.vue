<template>

    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <LabelForm label="Ícone:" />
                <span :class="icon.class" class="ms-2"></span>
            </div>

            <div class="input-group">
                <select @change="iconSourceChange" :class="[
                    'form-select',
                    {
                        'is-invalid': errors['icon.source']
                    }
                ]" v-model="icon.source">
                    <option selected>Origem</option>
                    <option value="local">Local</option>
                    <option value="html">HTML</option>
                </select>

                <input @input="getClassFromHtmlIcon" v-if="icon.source == 'html'"
                    type="text" :class="[
                        'form-control',
                        {
                            'is-invalid': errors['icon.class']
                        }
                    ]" placeholder="HTML do ícone aqui" v-model="icon.class">

                <ButtonUi v-else-if="icon.source == 'local'" @click="showIconsModal"
                    variant="outline-primary" text="Escolher" />

                <div v-else class="d-flex align-items-center px-2 t-auto">
                    Escolha uma origem
                </div>

                <select @change="iconPositionChange" v-if="!hidePositionField" :class="[
                    'form-select',
                    {
                        'is-invalid': errors['icon.position']
                    }
                ]" v-model="icon.position">
                    <option selected>Posição</option>
                    <option value="start">Início</option>
                    <option value="end">Final</option>
                </select>
            </div>

            <small v-if="errors['icon.source'] || errors['icon.position']"
                class="text-danger py-2">
                {{ errors['icon.source'] }} {{ errors['icon.position'] }}
            </small>
        </div>
    </div>

    <a v-if="icon.source == 'html'" @click.prevent="showIconsHelpModal" href="">
        <small>
            Como funciona?
        </small>
    </a>
</template>

<script>

import LabelForm from '../Form/LabelForm.vue';
import ButtonUi from '../Ui/ButtonUi.vue';

export default {
    components: { LabelForm, ButtonUi },

    props: {
        iconData: { type: Object, default: null },
        errors: { type: Object, default: {} },
        hidePositionField: { type: Boolean, default: false }
    },

    emits: {
        'iconHasSet': null,
        'requestingIconsModal': null,
        'requestingModalIconsHelp': null
    },

    data() {
        return {
            icon: {
                source: this.iconData.source ?? 'local',
                name: this.iconData.name ?? null,
                class: this.iconData.class ?? null,
                position: this.iconData.position ?? 'start'
            }
        }
    },

    watch: {
        iconData: {
            immediate: true,
            deep: true,
            handler(nv) {
                this.icon.source = nv.source;
                this.icon.name = nv.name;
                this.icon.class = nv.class;
                this.icon.position = nv.position;
            }
        }
    },

    methods: {
        iconSourceChange() {
            this.emitUpdateEvent();
        },

        getClassFromHtmlIcon(event) {
            let temp = document.createElement('div');

            if (event.target.value ?? null) {
                temp.innerHTML = event.target.value;
                this.icon.name = null;

                if (temp.firstChild instanceof Element || temp.firstChild instanceof HTMLElement) {
                    this.icon.class = temp.firstChild.getAttribute('class');
                }
            }

            this.emitUpdateEvent();
        },

        iconPositionChange() {
            this.emitUpdateEvent();
        },

        showIconsModal() {
            this.$emit('requestingIconsModal');
        },

        showIconsHelpModal() {
            this.$emit('requestingModalIconsHelp');
        },

        emitUpdateEvent() {
            this.$emit('iconHasSet', this.icon);
        }
    }
};

</script>