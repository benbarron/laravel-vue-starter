import './bootstrap';
import '@mdi/font/css/materialdesignicons.css';
import 'vuetify/dist/vuetify.min.css';
import Vue from 'vue';
import Vuetify from 'vuetify';
import VueProgressBar from 'vue-progressbar';
import Root from './components/Root.vue';
import store from './store';
import AxiosDetect from './utils/AxiosDetect';
import { router } from './router';

Vue.use(Vuetify);
Vue.component('root', Root);
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
      () => {
        // this.$Progress.start();
        this.$store.commit('showLoader');
      },
      () => {
        // this.$Progress.finish();
        this.$store.commit('hideLoader');
      }
    );
  }
});

app.$mount('#app');
