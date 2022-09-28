<template>
    <label v-if="label && !isCheckOrRadioType" :for="name" class="mb-1">
        {{ label }}
    </label>

    <GroupForm :is-check="isCheckOrRadioType" :is-radio="isCheckOrRadioType"
        :inline="inline">
        <input @input="updateValue" :class="inputStyle" :type="type" :id="name"
            :name="name" :readonly="readonly" :disabled="disabled" :value="modelValue"
            :autocomplete="type=='password'?'new-password':''" />

        <label v-if="label && isCheckOrRadioType" class="form-check-label" :for="name">
            {{ label }}
        </label>

        <small v-if="errorMessage" class="invalid-feedback">
            {{ errorMessage }}
        </small>
    </GroupForm>
</template>

<script>

import GroupForm from './GroupForm.vue';

export default {
    props: {
        label: { type: String, default: null },
        type: { type: String, default: "text" },
        name: { type: String, default: null },
        errorMessage: { type: String, default: null },
        modelValue: { type: [String, Number, Boolean], default: null },
        borderless: { type: Boolean, default: false },
        readonly: { type: Boolean, default: false },
        disabled: { type: Boolean, default: false },
        inline: { type: Boolean, default: false },
    },
    computed: {
        inputStyle() {
            return `${this.isCheckOrRadioType ? "form-check-input" : "form-control"} ${this.borderless ? "border-0" : ""} ${this.errorMessage ? "is-invalid" : ""}`;
        },
        isCheckOrRadioType() {
            return this.type == "checkbox" || this.type == "radio";
        }
    },
    methods: {
        updateValue(e) {
            if (this.type == 'file')
                this.$emit("update:modelValue", e);
            else
                this.$emit("update:modelValue", e.target.value);
        }
    },
    components: { GroupForm }
};
</script>