// Debug log to ensure the file is loaded
console.log("app.js loaded");

// Import jQuery and attach it globally
import $ from "jquery";
window.$ = window.jQuery = $;

// Import all Bootstrap exports and attach them to the global window object
import * as bootstrap from "bootstrap";
window.bootstrap = bootstrap;

// You can add additional custom JavaScript below
