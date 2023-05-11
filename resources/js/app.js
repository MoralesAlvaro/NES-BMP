import './bootstrap';
import '../css/app.css';
import '../css/style.css';
import "vue-select/dist/vue-select.css";

import { createApp, h } from 'vue';
import 'flowbite';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import vSelect from "vue-select";
import Toaster from "@meforma/vue-toaster";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Toaster)
			.component("v-select", vSelect)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
