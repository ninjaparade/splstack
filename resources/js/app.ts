import '../css/app.css'
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import Default from '../layouts/default.vue'

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob('../Pages/**/*.vue', { eager: true })

    const page = pages[`../Pages/${name}.vue`].default

    page.layout ??= Default

    return pages[`../Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el)
  },
})
