import preset from "./vendor/filament/support/tailwind.config.preset";
import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

export default {
    presets: [
        preset,
        require("./vendor/tallstackui/tallstackui/tailwind.config.js"),
    ],
    content: [
        "./app/Filament/**/*.php",
        "./resources/views/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
        "./vendor/tallstackui/tallstackui/src/**/*.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["DM Sans", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                main: "#ff4b4c",
            },
        },
    },

    plugins: [forms],
};
