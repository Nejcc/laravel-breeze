// app.js

// Import the initial setup file for the application.
// This file typically includes global styles, scripts, and other foundational configurations.
import './bootstrap';

// Import the createApp function from Vue to initialize the Vue application.
import { createApp } from 'vue';

// Import a pre-configured Axios instance for making HTTP requests.
// This instance likely includes default headers and base URL configurations.
import axiosInstance from './axiosInstance';

// Import constants such as APP_TOKEN and API_BASE_URL.
// These are generally used for API interactions and configuration settings.
import { APP_TOKEN, API_BASE_URL } from './constants';

// Import functions for registering Vue plugins and components globally.
// These functions help in adding additional functionality and reusable components to the application.
import registerPlugins from './registerPlugins';
import registerComponents from './registerComponents';

// Create a new Vue application instance.
// This instance will be used to configure and mount the Vue application.
const app = createApp({});

// Configure the global properties of the application.
// Here, the Axios instance is set as a global property, allowing it to be accessed within Vue components.
app.config.globalProperties.$axios = axiosInstance;

// Register global plugins for the Vue application.
// This step is essential for adding extended functionalities like routing, state management, etc.
registerPlugins(app);

// Register global components for the Vue application.
// This ensures that certain components are available throughout the application without individual imports.
registerComponents(app);

// Mount the Vue application to the DOM.
// The '#app' selector corresponds to the HTML element where the Vue app will be rendered.
app.mount('#app');
