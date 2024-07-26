import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import { run } from 'vite-plugin-run'
import Unimport from 'unimport/unplugin'
import AutoImport from 'unplugin-auto-import/vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/js/app.ts'],
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,

          includeAbsolute: false,
        },
      },
    }),
    AutoImport({
      include: [
        /\.vue$/,
        /\.vue\?vue/, // .vue
      ],
      imports: [
        {
          from: 'vue',
          imports: ['Component', 'ComponentPublicInstance', 'ComputedRef', 'ExtractDefaultPropTypes', 'ExtractPropTypes', 'ExtractPublicPropTypes', 'InjectionKey', 'PropType', 'Ref', 'VNode', 'WritableComputedRef'],

        },
        {
          from: '@vueuse/core',

          imports: ['onKeyStroke'],
        },
        {
          from: '@inertiajs/vue3',
          imports: ['useForm', 'Head', 'Link'],
          type: true,
        },
      ],
    }),
    Unimport.vite({
      imports: [
        { name: 'default', as: 'axios', from: 'axios' },
      ],
      addons: {
        vueTemplate: true,
      },
      dirs: [
        'resources/config/*',
        'resources/utils/*',
        'resources/composables/*',
      ],
    }),
    run([
      // Watch Data, DTOs, and Enums
      {
        name: 'Generate TypeScript Types',
        run: ['php', 'artisan', 'typescript:transform'],
        pattern: [
          '+(app|src)/**/*Data.php',
          '+(app|src)/**/Enums/*.php',
          '+(app|src)/**/Middleware/HandleInertiaRequests.php',
        ],
      },
    ]),
  ],

  build: {
    rollupOptions: {
      output: {
        chunkFileNames: (assetInfo) => {
          if (assetInfo.name?.endsWith('.vue_vue_type_style_index_0_lang')) {
            return `assets/${assetInfo.name.slice(0, -32)}-[hash:8].js`
          }
          else if (assetInfo.name?.endsWith('.vue_vue_type_script_setup_true_lang')) {
            return `assets/${assetInfo.name.slice(0, -36)}-[hash:8].js`
          }
          else {
            return 'assets/[name]-[hash:8].js'
          }
        },
      },
    },
  },
})
