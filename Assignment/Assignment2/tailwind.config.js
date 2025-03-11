module.exports = {
  content: [
    "./views/**/*.php",
    "./public/**/*.php",
    "./index.php",
    "./src/**/*.php"
  ],
  theme: {
    extend: {},
  },
  plugins: [require("daisyui")],
};