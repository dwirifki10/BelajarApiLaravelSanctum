import { createApp } from 'vue'
import App from './App.vue'

import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.min'
import router from './routes'

import axios from 'axios'
axios.defaults.withCredentials = true;

const app = createApp(App)

app.use(router)
app.mount('#app')
