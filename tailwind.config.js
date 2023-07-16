/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./assets/html/*.html",
        "./assets/master/*.html",
        "./assets/system/*.html",
        "./assets/script/*.js",
    ],
    theme: {
        extend: {},
        fontFamily: {
            heading: ["'Prata'", "serif"],
            body: ["'Inter'", "sans-serif"],
        },
    },
    plugins: [],
}

