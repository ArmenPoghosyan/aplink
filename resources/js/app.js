import '@quasar/extras/material-symbols-rounded/material-symbols-rounded.css';
import 'quasar/src/css/index.sass';
import '../css/app.scss';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { Dark, Dialog, LocalStorage, Notify, Quasar } from 'quasar';
import icon_set from 'quasar/icon-set/material-symbols-rounded';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { init_theme } from './composables/use_theme';

const app_name = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${app_name}` : app_name),
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(Quasar, {
                plugins: { Dark, Dialog, LocalStorage, Notify },
                iconSet: icon_set,
                config: {
                    notify: { position: 'top', timeout: 2500 },
                },
            });

        init_theme();

        return app.mount(el);
    },
    progress: {
        color: '#0e9fb8',
    },
});
