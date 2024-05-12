import { createApp } from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios';

axios.defaults.baseURL ='http://localhost:80/'
axios.defaults.withCredentials = true;

const app = createApp({ });
app.use(VueAxios, axios)