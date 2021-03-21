<template>
  <div class="container">
    <div class="row d-flex justify-content-center text-center">
      <div>
        <h2>Hello, You're logged in as:</h2>
        <h4>{{ user.name }} - {{ user.email }}</h4>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import store from './../store';

@Component
export default class Home extends Vue {
  mounted() {
    this.configureBreadcrumbs();
  }

  get user() {
    return store.getters.getUser;
  }

  configureBreadcrumbs() {
    store.commit('setBreadcrumbs', []);
    store.commit('setCallToAction', null);
  }

  startMeeting() {
    this.$router.push(`/meeting`);
  }
}
</script>
