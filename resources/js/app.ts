import './bootstrap';
import '../css/app.css';

import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { mask } from 'vue-the-mask'
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import * as fas from '@fortawesome/free-solid-svg-icons';

Object.keys(fas).forEach((iconName: any) => {
    if (fas[iconName] !== 'fas') {
        console.log(fas[iconName])

        library.add(fas[iconName]);
    }
});
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
    components,
    directives,
})
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(vuetify)
            .directive('mask', mask)
            .component('font-awesome-icon', FontAwesomeIcon)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#FFF2F4',
    },
});
