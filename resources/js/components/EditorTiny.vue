<template>
    <Editor @change="updateValue" :init="init" :initial-value="modelValue"
        :value="modelValue" output-format="html" :api-key="apiKey" />
</template>
  
<script>

const settings = {
    default: {
        language: 'pt_BR',
        menubar: false,
        toolbar_groups: {
            titles: {
                icon: 'format',
                tooltip: 'Títulos',
                items: 'h2 h3 h4 h5 h6 blockquote'
            },
            aligns: {
                icon: 'align-left',
                tooltip: 'Alinhamentos',
                items: 'alignleft aligncenter alignright alignnone'
            },
            subsup: {
                icon: 'superscript',
                tooltip: '',
                items: 'superscript subscript'
            },
            lists: {
                icon: 'ordered-list',
                tooltip: '',
                items: 'bullist numlist'
            }
        },
    },
    basic: {
        plugins: 'lists link code codesample help autosave anchor',
        toolbar: 'titles aligns | fontfamily fontsize forecolor backcolor removeformat | bold italic strikethrough underline | subsup | lists | link anchor code codesample',
    },
    full: {
        min_height: 475,
        plugins: 'lists link image table code codesample help wordcount autosave fullscreen anchor',
        toolbar: 'titles aligns | fontfamily fontsize forecolor backcolor removeformat | bold italic strikethrough underline | subsup | lists | image link table anchor code codesample fullscreen',

        image_caption: true,
        image_advtab: true,
        images_upload_url: route('admin.medias.images.upload'),
        images_upload_credentials: true,
        image_uploadtab: true,
        images_file_types: 'jpeg,jpg,png,webp',

        autosave_ask_before_unload: true, // default: true
        autosave_interval: '30s', // default: 30s
        autosave_retention: '20m', // default: 20m(tempo que o conteúdo salvo automaticamnete deverá ficar no armazenamento local do navegador)
    }
};

import Editor from '@tinymce/tinymce-vue';

export default {
    components: { Editor },
    props: {
        modelValue: { type: String, default: null },
        apiKey: { type: String, default: "no-api-key" },
        basic: { type: Boolean, default: false },
        minHeight: { type: [Number, String], default: null }
    },
    methods: {
        updateValue(event, editor) {
            this.$emit("update:modelValue", editor.getContent())
        }
    },
    computed: {
        init() {
            let defaultSettings = settings.default;
            let customSettings = this.basic ? settings.basic : settings.full;

            if (this.minHeight)
                customSettings.min_height = parseInt(this.minHeight);

            return {
                ...defaultSettings,
                ...customSettings
            };
        }
    },
}
</script>