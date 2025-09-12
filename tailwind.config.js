module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        screens: {
            'xs': '440px',
            'sm': '640px',
            'md': '768px',
            'lg': '1024px',
            'xl2': '1440px',
        },
        extend: {
            colors: {
                asig: {
                    lightGrey: '#F6F6F6',
                    successGreen: '#93C572',
                    lightGreen: '#EAF6F0'
                }
            },
            fontFamily: {
                montserratRegular: ['Montserrat-Regular'],
                montserratLight: ['Montserrat-Light'],
                montserratMedium: ['Montserrat-Medium'],
            },
        }
    },
    plugins: [],
}
