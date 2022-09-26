<template>
    <div class="container">
        <h1>OPA</h1>
        <slot />
    </div>
</template>
  
<script>

export default {
    components: {},
    data() {
        return {
            navs: [
                {
                    text: 'Dashboard',
                    url: this.$route("admin.index"),
                    activeIn: ['admin.index']
                },
            ],
        };
    },

    updated() {
        this.showFlashMessage();
    },

    methods: {
        showFlashMessage() {
            let flash = this.$page.props.flash;

            if (flash) {
                this.$refs.alert.add(flash.message, flash.variant);
            } else {
                this.$refs.alert.clear();
            }
        },
    }
}

</script>
