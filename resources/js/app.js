import './bootstrap';
import './axios.js'

import { createApp } from 'vue';

import App from './vue/App.vue'

import router from './router.js'

import mitt from 'mitt'

const emitter = mitt()

const app = createApp(App)
app.config.globalProperties.emitter = emitter
app.use(router)
app.mount("#app")
