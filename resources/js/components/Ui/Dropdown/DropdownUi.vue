<template>
    <div class="dropdown">
        <ButtonUi class="dropdown-toggle d-flex align-items-center" :text="text"
            type="button" :icon="icon" :variant="variant" aria-expanded="false"
            data-bs-toggle="dropdown">
            <template v-slot:buttonContent>
                <IconUi icon="userCircle" class="fs-4" style="line-height: 0;" />
                <span class="ms-2">{{ text }}</span>
            </template>
        </ButtonUi>
        <div class="dropdown-menu dropdown-menu-end">
            <slot v-if="$slots.dropdownMenu" name="dropdownMenu" />
            <DropdownItem v-else v-for="item in items" v-bind:key="item.text"
                :to="item.url" :text="item.text" :icon="item.icon" />
        </div>
    </div>
</template>

<script>

import ButtonUi from '../ButtonUi.vue';
import IconUi from '../IconUi.vue';
import DropdownItem from './DropdownItem.vue';

export default {
    components: { ButtonUi, IconUi, DropdownItem },
    data() {
        return {
        };
    },
    props: {
        text: { type: String, default: null },
        icon: { type: String, default: null },
        items: { type: Array, default: null },
        variant: { type: String, default: null }
    },
};
</script>