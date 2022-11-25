<template>
    <LabelForm v-if="label" :label="label" :name="name" />

    <GroupForm>
        <select @input="updateValue" :class="selectStyle" :name="name" :id="name"
            :readonly="readonly" :disabled="disabled" :value="modelValue">
            <option v-for="option in theOptions" v-bind:key="option.value"
                :value="option.value" v-html="option.text">
            </option>
        </select>

        <InvalidFeedbackForm v-if="errorMessage" :error-message="errorMessage" />
    </GroupForm>
</template>

<script>

import GroupForm from './GroupForm.vue';
import LabelForm from './LabelForm.vue';
import InvalidFeedbackForm from './InvalidFeedbackForm.vue';

export default {
    components: { GroupForm, LabelForm, InvalidFeedbackForm },
    props: {
        label: { type: String, default: null },
        name: { type: String, default: null },
        errorMessage: { type: String, default: null },
        modelValue: { type: [String, Number], default: "none" },
        options: { type: Array, default: [] },
        text: { type: String, default: null },

        readonly: { type: Boolean, default: false },
        disabled: { type: Boolean, default: false },
        onlyValues: { type: Boolean, default: false },
    },
    emits: {
        'hasChange': null,
        'update:modelValue': null
    },
    computed: {
        selectStyle() {
            return `form-select ${this.errorMessage ? "is-invalid" : ""}`;
        },
        theOptions() {
            if (!this.onlyValues) {
                return [
                    {
                        text: this.text ?? "Selecione um",
                        value: "none",
                    },
                    ...this.options,
                ];
            }

            return this.options;
        }
    },
    methods: {
        updateValue(e) {
            this.$emit("hasChange", e);
            this.$emit("update:modelValue", e.target.value);
        }
    },
};
</script>