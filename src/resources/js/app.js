import './bootstrap';
import '../css/app.css';

import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3'
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {FontAwesomeIcon} from '../js/icons.js'

createInertiaApp({
    // resolve: name => {
    //     const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    //     return pages[`./Pages/${name}.vue`]
    // },
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .component('font-awesome-icon', FontAwesomeIcon)
            .mount(el)
    },
})
