import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store';
import Home from './pages/Home.vue';
import Users from './pages/Users.vue';
import UsersCreate from './pages/UsersCreate.vue';
import UsersEdit from './pages/UsersEdit.vue';
import Meeting from './pages/Meeting.vue';

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
  },
  {
    label: 'Create User',
    path: '/users/create',
    icon: null,
    name: 'admin.users.create',
    component: UsersCreate
  },
  {
    label: 'Meeting',
    path: '/meeting',
    icon: null,
    name: 'dashboard.meeting',
    component: Meeting
  },
  {
    label: 'Edit User',
    path: '/users/edit/:id',
    icon: null,
    name: 'admin.users.edit',
    component: UsersEdit
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
