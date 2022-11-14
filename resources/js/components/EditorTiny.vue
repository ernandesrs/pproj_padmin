<template>
    <Editor @change="updateValue" :init="{
      min_height: 475,
      menubar: false,
      plugins: 'lists link image table code codesample help wordcount autosave fullscreen anchor',
      toolbar: 'titles aligns | fontfamily fontsize forecolor backcolor removeformat | bold italic strikethrough underline | subsup | lists | image link table anchor code codesample fullscreen',
      toolbar_groups: {
        titles: {
            icon: 'format',
            tooltip: 'Títulos',
            items: 'h2 h3 h4 h5 h6 blockquote'
        },
        aligns: {
            icon: 'align-left',
            tooltip: 'Alinhamenots',
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

      image_caption: true,
      image_advtab: true,
      images_upload_url: $route('admin.medias.images.upload'),
      images_upload_credentials: true,
      image_uploadtab: true,
      images_file_types: 'jpeg,jpg,png,webp',

      autosave_ask_before_unload: true, // default: true
      autosave_interval: '30s', // default: 30s
      autosave_retention: '20m', // default: 20m(tempo que o conteúdo salvo automaticamnete deverá ficar no armazenamento local do navegador)
    }" :initial-value="modelValue" :value="modelValue" output-format="html"
        :api-key="apiKey" />
</template>
  
<script>

import Editor from '@tinymce/tinymce-vue'

export default {
    components: { Editor },
    props: {
        modelValue: { type: String, default: null },
        apiKey: { type: String, default: "no-api-key" }
    },
    methods: {
        updateValue(event, editor) {
            this.$emit("update:modelValue", editor.getContent())
        }
    }
}
</script>