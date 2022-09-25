<template>
    <main class="w-full h-full flex justify-center items-center container mx-auto py-5 px-4">
        <div class="bg-gray-100 w-full sm:w-96 md:w-3/5 lg:w-2/5 shadow-md">
            <header class="bg-blue-800 text-gray-300 flex justify-center pt-1">
                <Link class="px-4 py-2"
                    :class="{'bg-gray-100 text-gray-800': $page.url == '/auth/login'}"
                    href="/auth/login">
                Entrar
                </Link>
                <Link class="px-4 py-2"
                    :class="{'bg-gray-100 text-gray-800':  $page.url == '/auth/register'}"
                    href="/auth/register">
                Cadastrar
                </Link>
            </header>
            <div class="pt-5 pb-8 px-6">
                <slot />
            </div>
        </div>
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
