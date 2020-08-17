import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    breadcrumbs: [],
    callToAction: null,
    showLoader: false,
    dialog: null,
    snackbar: {
      color: null,
      message: null,
      timeout: 5000,
      show: false
    },
    user: {}
  },
  mutations: {
    showLoader(state) {
      state.showLoader = true;
    },
    hideLoader(state) {
      state.showLoader = false;
    },
    setUser(state, user) {
      state.user = user;
    },
    setBreadcrumbs(state, breadcrumbs) {
      state.breadcrumbs = breadcrumbs;
    },
    setCallToAction(state, callToAction) {
      state.callToAction = callToAction;
    },
    setSnackbar(state, snackbar) {
      state.snackbar = snackbar;
    }
  },
  getters: {
    getShowLoader(state) {
      return state.showLoader;
    },
    getUser(state) {
      return state.user;
    },
    getBreadcrumbs(state) {
      return state.breadcrumbs;
    },
    getCallToAction(state) {
      return state.callToAction;
    },
    getSnackbar(state) {
      return state.snackbar;
    }
  }
});
