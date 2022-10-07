import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import Str from './Utils/string';

InertiaProgress.init();

createInertiaApp({
    resolve: name => import(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        const vueApp = createApp({ render: () => h(App, props) });

        vueApp.config.globalProperties.$route = route;
        vueApp.config.globalProperties.$helpers = {
            string: Str
        };

        vueApp.use(plugin)
            .mount(el)
    },
});

