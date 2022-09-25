<template>
    <label v-if="label" :for="name" class="mb-1">
        {{ label }}
    </label>
    <div class="input-group has-validation mb-3">
        <input @input="updateValue" :class="style" :type="type" :id="name" :name="name"
            :readonly="readonly" :disabled="disabled" :value="modelValue" />

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
        disabled: { type: Boolean, default: false }
    },

    computed: {
        style() {
            return `form-control ${this.borderless ? "border-0" : ""} ${this.errorMessage ? "is-invalid" : ""}`;
        },
    },

    methods: {
        updateValue(e) {
            this.$emit("update:modelValue", e.target.value);
        }
    },
};
</script>