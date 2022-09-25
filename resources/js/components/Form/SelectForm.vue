<template>
    <label v-if="label && !isCheckOrRadioType" :for="name" class="mb-1">
        {{ label }}
    </label>

    <GroupForm>
        <select @input="updateValue" :class="selectStyle" :name="name" :id="name"
            :readonly="readonly" :disabled="disabled" :value="modelValue">
            <option v-for="option in theOptions" v-bind:key="option.value"
                :value="option.value">
                {{ option.text }}
            </option>
        </select>
        <small v-if="errorMessage" class="invalid-feedback">
            {{ errorMessage }}
        </small>
    </GroupForm>
</template>

<script>

import GroupForm from './GroupForm.vue';

export default {
    components: { GroupForm },
    props: {
        label: { type: String, default: null },
        name: { type: String, default: null },
        modelValue: { type: String, default: "none" },
        options: { type: Array, default: [] },
        text: { type: String, default: null },

        readonly: { type: Boolean, default: false },
        disabled: { type: Boolean, default: false },
    },
    computed: {
        selectStyle() {
            return `form-select`;
        },
        theOptions() {
            return [
                {
                    text: this.text ?? "Selecione um",
                    value: "none",
                },
                ...this.options,
            ];
        }
    },
    methods: {
        updateValue(e) {
            this.$emit("update:modelValue", e.target.value);
        }
    },
};
</script>