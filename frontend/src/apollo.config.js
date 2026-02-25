// apollo.config.js
module.exports = {
  client: {
    service: {
      name: "studio",
      // You can leave this as localhost for your IDE tools
      url: process.env.NODE_ENV === 'production' 
        ? "https://api.holyfamilymedia.org/graphql"
        : "http://127.0.0.1:8000/graphql",
    },
    // Files processed by the extension
    includes: ["src/**/*.vue", "src/**/*.js"],
  },
};