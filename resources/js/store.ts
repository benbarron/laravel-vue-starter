import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    breadcrumbs: [],
    showLoader: false,
    dialog: {
      show: false,
      title: '',
      type: '',
      icon: '',
      okayCallback: () => {},
      cancelCallback: () => {}
    }
  },
  mutations: {
    showLoader(state) {
      state.showLoader = true;
    },
    hideLoader(state) {
      state.showLoader = false;
    }
  },
  getters: {
    getShowLoader(state) {
      return state.showLoader;
    }
  }
});
