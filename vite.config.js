import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import { run } from 'vite-plugin-run'
import Unimport from 'unimport/unplugin'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/js/app.ts'],
      refresh: true,
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
