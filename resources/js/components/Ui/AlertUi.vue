<template>
    <FadeTransition>
        <div v-if="theMessage" :class="alertStyle" role="alert">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center me-auto">
                    <IconUi :icon="alertIcon" class="alert-icon" />
                    <p class="mb-0 ms-3" v-html="theMessage"></p>
                </div>
                <ButtonUi @click="clear" type="button" icon="xLg" size="sm" />
            </div>
        </div>
    </FadeTransition>
</template>

<script>

import ButtonUi from './ButtonUi.vue';
import IconUi from './IconUi.vue';
import FadeTransition from '../FadeTransition.vue';

export default {
    components: { ButtonUi, IconUi, FadeTransition },
    data() {
        return {
            theMessage: null,
            theVariant: null
        };
    },
    props: {
        variant: { type: String, default: "default" },
        message: { type: String, default: null },
        fixed: { type: Boolean, default: false },
        position: { type: String, default: 'top' },
    },
    watch: {
        message: {
            immediate: true,
            handler(nv) {
                this.theMessage = nv;
            }
        },
        variant: {
            immediate: true,
            handler(nv) {
                this.theVariant = nv;
            }
        }
    },
    computed: {
        alertStyle() {
            let position = this.position == 'top' ? 'alert-float-top' : 'alert-float-bottom';
            return `alert alert-${this.theVariant} ${!this.fixed ? 'alert-float ' + position : ''} py-2`;
        },

        alertIcon() {
            let alertIcons = {
                default: 'infoCircleFill',
                success: 'checkCircleFill',
                info: 'infoCircleFill',
                warning: 'exclamationCircleFill',
                danger: 'exclamationCircleFill'
            };
            return `${alertIcons[this.theVariant]}`;
        }
    },
    methods: {
        add(message, variant) {
            this.theMessage = message;
            this.theVariant = variant;
        },
        clear() {
            this.theMessage = null;
            this.theVariant = null;
        }
    }
};
</script>