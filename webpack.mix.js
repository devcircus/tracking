const cssImport = require('postcss-import');
const cssNesting = require('postcss-nesting');
const mix = require('laravel-mix');
const path = require('path');
const tailwindcss = require('tailwindcss');

class TailwindExtractor {
    static extract (content) {
        return content.match(/[\w-/:]+(?<!:)/g) || [];
    }
}

const purgecss = require('@fullhuman/postcss-purgecss')({
    content: [
        path.join(__dirname, 'resources/views/**/*.blade.php'),
        path.join(__dirname, 'resources/js/**/*.vue'),
    ],
    whitelist: ['html', 'body'],
    whitelistPatterns: [/^attachment/, /^v-/, /^nprogress/, /^spinner/, /^peg/, /^bar/, /^vdp/, /^report/, /^vgt/, /^footer/, /^form-/, /^text-/, /^column/, /^bordered/, /^clickable/, /^logged/],
    extractors: [
        {
            extractor: TailwindExtractor,
            extensions: ['html', 'js', 'php', 'vue'],
        },
    ],
});

mix.js('resources/js/main.js', 'public/js')
    .postCss('resources/css/main.css', 'public/css', [
        cssImport(),
        cssNesting(),
        tailwindcss('tailwind.config.js'),
        ...process.env.NODE_ENV === 'production' ? [purgecss]: [],
    ])
    .webpackConfig({
        output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
        resolve: {
            alias: {
                'vue$': 'vue/dist/vue.runtime.js',
                '@': path.resolve('resources/js'),
                JS: path.resolve(__dirname, 'resources/js'),
                Utils: path.resolve(__dirname, 'resources/js/Utils'),
                Pages: path.resolve(__dirname, 'resources/js/Pages'),
                Shared: path.resolve(__dirname, 'resources/js/Shared'),
                Libraries: path.resolve(__dirname, 'resources/js/lib'),
                Models: path.resolve(__dirname, 'resources/js/models'),
                Config: path.resolve(__dirname, 'resources/js/config'),
                Events: path.resolve(__dirname, 'resources/js/events'),
                Mixins: path.resolve(__dirname, 'resources/js/mixins'),
            },
        },
    })
    .babelConfig({
        plugins: ['@babel/plugin-syntax-dynamic-import'],
    })
    .version()
    .sourceMaps();
