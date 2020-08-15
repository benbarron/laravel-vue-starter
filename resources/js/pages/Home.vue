<template>
  <div class="container">
    <div class="row d-flex justify-content-center text-center">
      <div>
        <h2>Hello, You're logged in as:</h2>
        <h2>{{ user.name }}</h2>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import axios, { AxiosResponse } from 'axios';
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
}
</script>
