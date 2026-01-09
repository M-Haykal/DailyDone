/** @type {import('tailwindcss').Config} */
export default {
    // darkMode: "class",
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            
        },
        daisyui: {
            themes: [
                {
                    light: {
                        primary: "#0288D1",
                        secondary: "#90A4AE",
                        accent: "#FFD54F",

                        neutral: "#262626",
                        "base-100": "#fdfefe",
                        "base-200": "#F0F4F8",
                        "base-300": "#E2E8F0",

                        success: "#2E7D32",
                        warning: "#F57F17",
                        error: "#C62828",
                    },
                },
                {
                    dark: {
                        primary: "#4FC3F7",
                        secondary: "#90A4AE",
                        accent: "#FFD54F",

                        neutral: "#F0F4F8",
                        "base-100": "#0a0a0a",
                        "base-200": "#1a1a1a",
                        "base-300": "#262626",

                        success: "#81C784",
                        warning: "#FFD54F",
                        error: "#E57373",
                    },
                },
            ],
        },
    },
    plugins: [require("daisyui")],
};
