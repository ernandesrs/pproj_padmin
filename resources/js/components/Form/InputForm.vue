<template>
    <label v-if="label && !isCheckOrRadioType" :for="name" class="mb-1">
        {{ label }}
    </label>

    <div :class="inputContainerStyle">
        <input @input="updateValue" :class="inputStyle" :type="type" :id="name"
            :name="name" :readonly="readonly" :disabled="disabled" :value="modelValue"
            :autocomplete="type=='password'?'new-password':''" />

        <label v-if="label && isCheckOrRadioType" class="form-check-label" :for="name">
            {{ label }}
        </label>

        <small v-if="errorMessage" class="invalid-feedback">
            {{ errorMessage }}
        </small>
    </div>
</template>

<script>
export default {
    props: {
        label: { type: String, default: null },
        type: { type: String, default: 'text' },
        name: { type: String, default: null },
        errorMessage: { type: String, default: null },
        modelValue: { type: [String, Number, Boolean], default: null },

        borderless: { type: Boolean, default: false },
        readonly: { type: Boolean, default: false },
        disabled: { type: Boolean, default: false },
        inline: { type: Boolean, default: false },
    },

    computed: {
        inputContainerStyle() {
            return `${this.isCheckOrRadioType ? 'form-check' + (this.inline ? ' form-check-inline' : '') : 'input-group'} has-validation mb-3`;
        },

        inputStyle() {
            return `${this.isCheckOrRadioType ? "form-check-input" : "form-control"} ${this.borderless ? "border-0" : ""} ${this.errorMessage ? "is-invalid" : ""}`;
        },

        isCheckOrRadioType() {
            return this.type == "checkbox" || this.type == "radio";
        }
    },

    methods: {
        updateValue(e) {
            this.$emit("update:modelValue", e.target.value);
        }
    },
};
</script>