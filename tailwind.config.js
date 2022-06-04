//const colors = require("tailwindcss/colors");
const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // https://uicolors.app/create
                systems: {
                    50: "#f0f6fd",
                    100: "#e3eefc",
                    200: "#ccdef9",
                    300: "#adc8f4",
                    400: "#8ca8ed",
                    500: "#718ae3",
                    600: "#5566d6",
                    700: "#4654bc",
                    800: "#3b4798",
                    900: "#191e38",
                },
            },
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
