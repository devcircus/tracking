module.exports = {
    theme: {
        screens: {
          sm: '640px',
          md: '768px',
          lg: '1024px',
          xl: '1280px',
        },
        fill: theme => ({
            current: 'currentColor',
            'white': theme('colors.white'),
            'blue-100': theme('colors.blue.100'),
            'blue-200': theme('colors.blue.200'),
            'blue-300': theme('colors.blue.300'),
            'blue-400': theme('colors.blue.400'),
            'blue-500': theme('colors.blue.500'),
            'blue-600': theme('colors.blue.600'),
            'blue-700': theme('colors.blue.700'),
            'blue-800': theme('colors.blue.800'),
            'blue-900': theme('colors.blue.900'),
            'yellow-100': theme('colors.yellow.100'),
            'yellow-200': theme('colors.yellow.200'),
            'yellow-300': theme('colors.yellow.300'),
            'yellow-400': theme('colors.yellow.400'),
            'yellow-500': theme('colors.yellow.500'),
            'yellow-600': theme('colors.yellow.600'),
            'yellow-700': theme('colors.yellow.700'),
            'yellow-800': theme('colors.yellow.800'),
            'yellow-900': theme('colors.yellow.900'),
            'red-100': theme('colors.red.100'),
            'red-200': theme('colors.red.200'),
            'red-300': theme('colors.red.300'),
            'red-400': theme('colors.red.400'),
            'red-500': theme('colors.red.500'),
            'red-600': theme('colors.red.600'),
            'red-700': theme('colors.red.700'),
            'red-800': theme('colors.red.800'),
            'red-900': theme('colors.red.900'),
            'indigo-100': theme('colors.indigo.100'),
            'indigo-200': theme('colors.indigo.200'),
            'indigo-300': theme('colors.indigo.300'),
            'indigo-400': theme('colors.indigo.400'),
            'indigo-500': theme('colors.indigo.500'),
            'indigo-600': theme('colors.indigo.600'),
            'indigo-700': theme('colors.indigo.700'),
            'indigo-800': theme('colors.indigo.800'),
            'indigo-900': theme('colors.indigo.900'),
        }),
        width: theme => ({
            auto: 'auto',
            ...theme('spacing'),
            '1/2': '50%',
            '1/3': '33.33333%',
            '2/3': '66.66667%',
            '1/4': '25%',
            '3/4': '75%',
            '1/5': '20%',
            '2/5': '40%',
            '3/5': '60%',
            '4/5': '80%',
            '1/6': '16.66667%',
            '5/6': '83.33333%',
            '1/7': '14.286%',
            '2/7': '28.572%',
            '3/7': '42.858%',
            '4/7': '57.144%',
            '5/7': '71.43%',
            '6/7': '85.716%',
            full: '100%',
            screen: '100vw',
        }),
        minHeight: {
            '0': '0',
            full: '100%',
            screen: '100vh',
        },
        extend: {
            fontFamily: {
                'lato': [
                    'lato',
                    'system-ui',
                    'BlinkMacSystemFont',
                    '-apple-system',
                    'Segoe UI',
                    'Roboto',
                    'Oxygen',
                    'Ubuntu',
                    'Cantarell',
                    'Fira Sans',
                    'Droid Sans',
                    'Helvetica Neue',
                    'sans-serif',
                ],
            },
            spacing: {
              '7': '1.75rem',
            },
        },
    },
    variants: {
        textColor: ['responsive', 'hover', 'focus', 'group-hover'],
        textWeight: ['responsive'],
        fill: ['hover', 'focus', 'group-hover'],
        width: ['responsive'],
        margin: ['last-child', 'responsive'],
    },
    plugins: [
        require('./resources/js/lib/tailwindcss/plugins/tables')(),
        function ({ addVariant, e }) {
            addVariant('last-child', ({ modifySelectors, separator }) => {
                modifySelectors(({ className }) => {
                    return `.${e(`last-child${separator}${className}`)}:last-child`
                })
            })
        },
        require('@tailwindcss/custom-forms'),
      ],
}
