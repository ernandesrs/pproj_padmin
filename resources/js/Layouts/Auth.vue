<template>
    <main>
        <header>
            <Link href="/">Entrar</Link>
            <Link href="/">Cadastrar</Link>
        </header>
        <article>
            <slot />
        </article>
    </main>
</template>
  
<script>

import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Link,
    }
}
</script>