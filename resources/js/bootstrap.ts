import axios from 'axios';
import vue from 'vue';

declare const window: any;

window.Vue = vue;
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="api-token"]');

if (token) {
  let content = token.getAttribute('content');
  window.__TOKEN__ = token.getAttribute('content');
  window.axios.defaults.headers.common['Authorization'] = `Bearer ${content}`;
} else {
  console.error(
    'CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token'
  );
}
