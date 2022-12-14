<template>
    <FadeTransition>
        <div @mouseover="alertMouseOver" @mouseout="alertMouseOut" v-if="theMessage"
            :class="alertStyle" role="alert">
            <div class="alert-inner d-flex align-items-center py-2 px-3">
                <div class="d-flex align-items-center me-auto">
                    <IconUi :icon="alertIcon" class="alert-icon" />
                    <p class="mb-0 ms-3" v-html="theMessage"></p>
                </div>
                <ButtonUi @click="clear" type="button" icon="xLg" size="sm" />
            </div>
            <div v-if="time" class="alert-timer" :style="[`width:${timeStatus}%;`]"></div>
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
            theVariant: null,
            time: null,
            timeStatus: 0,
            timerHandler: null,
            intervalHandler: null,
        };
    },
    props: {
        variant: { type: String, default: "default" },
        message: { type: String, default: null },
        fixed: { type: Boolean, default: false },
        noAutoClose: { type: Boolean, default: false },
        position: { type: String, default: 'top' },
        flash: { type: Object, default: null }
    },
    watch: {
        flash: {
            deep: true,
            immediate: true,
            handler(nv) {
                if (nv)
                    this.add(nv.message, nv.variant);
            }
        },
        message: {
            immediate: true,
            handler(nv) {
                this.add(nv, this.variant);
            }
        },
    },
    computed: {
        alertStyle() {
            let position = this.position == 'top' ? 'alert-float-top' : 'alert-float-bottom';
            return `alert alert-${this.theVariant} ${!this.fixed ? 'alert-float ' + position : ''} py-0 px-0`;
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
        },
    },
    methods: {
        alertMouseOver() {
            if (!this.noAutoClose)
                this.timerReset();
        },
        alertMouseOut() {
            if (!this.noAutoClose)
                this.timer();
        },
        add(message, variant) {
            this.theMessage = message;
            this.theVariant = variant;

            if (this.timerHandler)
                this.timerReset();

            if (!this.noAutoClose) {
                this.time = 10;
                this.timer();
            }
        },
        clear() {
            this.theMessage = null;
            this.theVariant = null;
            if (!this.noAutoClose && this.timerHandler) {
                this.timerReset();
            }
        },
        timer() {
            this.timerHandler = setTimeout(() => {
                this.clear();
            }, this.time * 1000);

            this.intervalHandler = setInterval(() => {
                this.timeStatus++;
            }, 100);
        },
        timerReset() {
            clearTimeout(this.timerHandler);
            clearInterval(this.intervalHandler);
            this.timeStatus = 0;
        }
    }
};
</script>