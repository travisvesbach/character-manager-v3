require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });

window.dice = {
    roll: function(number = 20) {
        return Math.floor(Math.random() * number) + 1
    },
}

// use parseInt() to get number from string
// if isNaN, return passed default value
window.getNumber = function(value, default_value = 0) {
    let num = parseInt(value, 10);
    return isNaN(num) ? default_value : num;
}
