import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store';
import Home from './pages/Home.vue';
import Users from './pages/Users.vue';

Vue.use(VueRouter);

const routes = [
  {
    label: 'Home',
    path: '/home',
    icon: 'home',
    name: 'admin.home',
    component: Home
  },
  {
    label: 'Users',
    path: '/users',
    icon: 'people',
    name: 'admin.users',
    component: Users
  }
];

const router = new VueRouter({
  mode: 'history',
  routes
});

router.beforeEach((to, from, next) => {
  store.commit('showLoader');
  next();
});

router.afterEach((to, from) => {
  setTimeout(() => {
    store.commit('hideLoader');
  }, 1000);
});

export { routes, router };
