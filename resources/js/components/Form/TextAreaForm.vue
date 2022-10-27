<template>
    <LabelForm v-if="label" :label="label" :name="name" />

    <GroupForm>
        <textarea @input="updateValue" :class="inputStyle" :id="name" :name="name"
            :readonly="readonly" :disabled="disabled" :value="modelValue" :rows="rows" />

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
        modelValue: { type: [String, Number, Boolean], default: null },
        borderless: { type: Boolean, default: false },
        readonly: { type: Boolean, default: false },
        disabled: { type: Boolean, default: false },
        rows: { type: [String, Number], default: 2 }
    },
    computed: {
        inputStyle() {
            return `form-control ${this.borderless ? "border-0" : ""} ${this.errorMessage ? "is-invalid" : ""}`;
        }
    },
    methods: {
        updateValue(e) {
            this.$emit("update:modelValue", e.target.value);
        }
    },
};
</script>