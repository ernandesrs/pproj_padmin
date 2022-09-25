<template>
    <main class="main">
        <div class="container">
            <div class="box">
                <header class="bg-dark d-flex justify-content-center pt-1">
                    <Link class="px-4 py-2"
                        :class="{'bg-light text-dark': $page.url == '/auth/login'}"
                        href="/auth/login">
                    Entrar
                    </Link>
                    <Link class="px-4 py-2"
                        :class="{'bg-light text-dark':  $page.url == '/auth/register'}"
                        href="/auth/register">
                    Cadastrar
                    </Link>
                </header>
                <div class="">
                    <div class="card card-body border-0">
                        <slot />
                    </div>
                </div>
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

<style>
.main {
    width: 100%;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.main>.container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.main>.container>.box {
    width: 100%;
    max-width: 375px;
}
</style>