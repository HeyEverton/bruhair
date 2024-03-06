import './bootstrap';
import '../css/app.css';

import {createApp, h, DefineComponent} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';
import {mask} from 'vue-the-mask'
import {library} from '@fortawesome/fontawesome-svg-core';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import * as fas from '@fortawesome/free-solid-svg-icons';
import InfiniteLoading from 'v3-infinite-loading'
import {vue3Debounce} from 'vue-debounce'


import VueSweetalert2 from 'vue-sweetalert2';

// Styles
import 'sweetalert2/dist/sweetalert2.min.css';
import 'v3-infinite-loading/lib/style.css'

Object.keys(fas).forEach((iconName: any) => {
    if (fas[iconName] !== 'fas') {
        library.add(fas[iconName]);
    }
});
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
import 'vuetify/styles'
import {createVuetify} from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
    components,
    directives,
})
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(VueSweetalert2)
            .use(plugin)
            .use(vuetify)
            .directive('mask', mask)
            // components
            .component('font-awesome-icon', FontAwesomeIcon)
            .directive('debounce', vue3Debounce({lock: true}))
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#FFF2F4',
    },
});
