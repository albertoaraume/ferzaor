import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
            'resources/css/bootstrap.min.css',
                'resources/css/style.css',
                'resources/js/script.js',
                'resources/js/app.js',

                'resources/js/pages/reportes/reservas/yates.js',
                'resources/js/pages/reportes/reservas/actividades.js',
                  'resources/js/pages/reportes/reservas/tours.js',
                  'resources/js/pages/reportes/reservas/transportaciones.js',

                'resources/js/pages/reportes/ventas/enm.js',
                    'resources/js/pages/reportes/ventas/cortes.js',
                'resources/js/pages/reportes/ventas/corte-detalle.js',
                    
                  'resources/js/pages/reportes/estado-cuenta.js',
                'resources/js/pages/finanzas/ingresos/index.js',

                'resources/js/pages/ventas/facturas/index.js',
                'resources/js/pages/ventas/reservas/index.js',

                'resources/js/pages/dashboards/ventas/index.js'
            ],
            refresh: true,
        }),
         viteStaticCopy({
            targets: [
                {
                    src: 'resources/css',
                    dest: ''
                },
                {
                    src: 'resources/fonts',
                    dest: ''
                },
                {
                    src: 'resources/img',
                    dest: ''
                },
                {
                    src: 'resources/js',
                    dest: ''
                },

                {
                    src: 'resources/plugins',
                    dest: ''
                },

            ]
        }),
    ],
     resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '$': 'jQuery',
      'moment': path.resolve(__dirname, 'node_modules/moment/moment.js'),
        //'moment': path.resolve(__dirname, 'node_modules/moment'),
        }
    },
});
