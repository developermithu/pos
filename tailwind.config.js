import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",

        // Mary UI
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php",
    ],

    daisyui: {
        themes: ["light", "dark"],
    },

    safelist: [
        "w-64",
        "w-1/2",
        "rounded-l-lg",
        "rounded-r-lg",
        "bg-gray-200",
        "grid-cols-4",
        "grid-cols-7",
        "h-6",
        "leading-6",
        "h-9",
        "leading-9",
        "shadow-lg",
        "bg-opacity-50",
        "dark:bg-opacity-80",
    ],

    theme: {
        extend: {
            colors: {
                primary: "#5D00BB",
                danger: "#dc2626",
                success: "#059669",
            },

            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },

            transitionProperty: {
                width: "width",
            },

            textDecoration: ["active"],

            minWidth: {
                kanban: "28rem",
            },
        },
    },

    plugins: [forms, require("@tailwindcss/typography"), require("daisyui")],
};
