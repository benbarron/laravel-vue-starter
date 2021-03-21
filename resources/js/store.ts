import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    breadcrumbs: [],
    callToAction: null,
    showLoader: false,
    dialog: null,
    callInvites: [],
    snackbar: {
      color: null,
      message: null,
      timeout: 6000,
      show: false
    },
    user: {}
  },
  mutations: {
    addInvite(state, invite) {
      state.callInvites.push(invite as never);
    },
    removeInvite(state, inviteId) {
      state.callInvites = state.callInvites.filter((invite: any) => invite.call_id === inviteId);
    },
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
    getInvites(state) {
      return state.callInvites;
    },
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
