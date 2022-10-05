<template>
    <Editor @change="updateValue" :init="{
    menubar: false,
    plugins: 'lists link image table code help wordcount',
    toolbar: 'titles aligns | fontfamily fontsize forecolor backcolor removeformat | bold italic strikethrough underline | subsup | lists | image link table code',
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
    }" :initial-value="modelValue" :value="modelValue" output-format="html"
        api-key="no-api-key" />
</template>
  
<script>

import Editor from '@tinymce/tinymce-vue'

export default {
    components: { Editor },
    props: {
        modelValue: { type: String, default: '' }
    },
    methods: {
        updateValue(event) {
            console.log(event.target.$);
        }
    }
}
</script>
