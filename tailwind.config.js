/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/**/*.{vue,js,ts,blade.php}"],
    theme: {
        extend: {
            backgroundColor: {
                container: "#2b2738",
                theme: "#5a556b",
                input: "#3b364c",
                btn: {
                    default: "#6e54b5",
                    hover: "#6c47d0",
                    disabled: "#4f3c83",
                },
            },
            colors: {
                link: "#6e54b5",
            },
            borderColor: {
                input: {
                    default: "#4c475b",
                    focus: "#6e54b5",
                },
                checkbox: "#6e54b5",
            },
            minHeight: { screen: ["100vh", "100dvh"] },
        },
    },
    plugins: [],
};
