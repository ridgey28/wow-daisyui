/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.php", "./*/*.php", "./*/*/*.php", "./assets/dev/js/*.js"],
  theme: {
    extend: {},
  },
  plugins: [require("daisyui")],
}
