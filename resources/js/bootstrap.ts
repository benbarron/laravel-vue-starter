import axios from 'axios';
import vue from 'vue';

declare const window: any;

window.Vue = vue;
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
