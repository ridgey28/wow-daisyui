/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["*.php", "./*.php", "./*/*.php", "./*/*/*.php", "./dev/js/*.js"],
  theme: {},
  darkMode: "class",
  variants: {
    extend: {},
  },
  plugins: [require("@tailwindcss/typography")],
};
