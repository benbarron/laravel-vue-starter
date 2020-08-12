import './bootstrap';
import '@mdi/font/css/materialdesignicons.css';
import 'vuetify/dist/vuetify.min.css';
import Vue from 'vue';
import Vuetify from 'vuetify';
import VueProgressBar from 'vue-progressbar';
import Root from './components/Root.vue';
import store from './store';
import { router } from './router';
import AxiosDetect from './utils/AxiosDetect';

Vue.use(Vuetify);

Vue.use(VueProgressBar, {
  color: '#3f51b5',
  failedColor: '#b71c1c',
  thickness: '5px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  inverse: false
});

Vue.component('root', Root);

const vuetify = new Vuetify({
  theme: {
    dark: true,
    themes: {
      dark: {
        primary: '#3f51b5',
        info: '#4c86b5',
        success: '#17b535',
        secondary: '#b0bec5',
        accent: '#8c9eff',
        error: '#b71c1c'
      }
    }
  },
  icons: {
    iconfont: 'mdi'
  }
});

const app: Vue = new Vue({
  router,
  store,
  vuetify,
  mounted() {
    AxiosDetect.init(
      () => this.$Progress.start(),
      () => this.$Progress.finish()
    );
  }
});

app.$mount('#app');
