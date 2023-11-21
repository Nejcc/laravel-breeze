// registerPlugins.js

// Importing a specific pagination component from the 'laravel-vue-pagination' package.
// This component is designed to work with Bootstrap 5 and provides a Vue-compatible pagination component
// that can be used in conjunction with Laravel's pagination features.
//import { Bootstrap5Pagination } from "laravel-vue-pagination";

/**
 * Registers global plugins for the Vue application.
 * 
 * This function is responsible for registering various plugins that enhance the functionality
 * of the Vue application. By registering these plugins globally, they can be used throughout
 * the application without the need to import them in individual components.
 * 
 * @param {Object} app - The Vue application instance created by the `createApp` function.
 *                       This instance is used to register global components and plugins.
 */
export default function registerPlugins(app) {
    // Registering the 'pagination' component globally.
    // This makes the 'pagination' component from 'laravel-vue-pagination' available throughout
    // the Vue application. It can be used in any component template without additional imports.
    //app.component('pagination', Bootstrap5Pagination);
}
