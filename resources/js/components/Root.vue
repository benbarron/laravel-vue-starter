<style>
.v-breadcrumb:hover {
  cursor: pointer;
}
hr.v-divider {
  margin-top: 0 !important;
}
</style>

<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="showDrawer" app clipped left>
      <v-list dense>
        <div v-for="route in routes" :key="route.name">
          <v-list-item @click="redirect(route.path)">
            <v-list-item-action>
              <v-icon>{{ route.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{ route.label }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </div>
        <v-list-item @click="logout()">
          <v-list-item-action>
            <v-icon>directions_walk</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Logout</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app clipped-left>
      <v-app-bar-nav-icon @click="toggleShowDrawer()"></v-app-bar-nav-icon>
      <v-toolbar-title>{{ appName }}</v-toolbar-title>
    </v-app-bar>

    <v-main>
      <div class="container d-flex justify-content-between align-items-center">
        <div v-if="breadcrumbs.length > 0">
          <v-breadcrumbs :items="breadcrumbs">
            <template v-slot:item="{ item }">
              <v-breadcrumbs-item @click="redirect(item.href)" :disabled="false" class="v-breadcrumb">
                {{ item.text.toUpperCase() }}
              </v-breadcrumbs-item>
            </template>
          </v-breadcrumbs>
        </div>
        <v-btn v-if="callToAction" color="primary" @click="redirect(callToAction.href)">{{
          callToAction.text
        }}</v-btn>
      </div>
      <div v-if="breadcrumbs.length > 0 || callToAction">
        <v-divider></v-divider>
      </div>
      <div v-if="showLoader" class="wask_loader bg_half_transparent">
        <moon-loader color="red"></moon-loader>
      </div>
      <div v-if="snackbar.show">
        <v-snackbar :color="snackbar.color" top v-model="snackbar.show">
          {{ snackbar.message }}
        </v-snackbar>
      </div>
      <transition name="fade">
        <router-view></router-view>
      </transition>
    </v-main>
    <v-footer>Copyright 2020</v-footer>
    <vue-progress-bar></vue-progress-bar>
  </v-app>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { Prop, Inject } from 'vue-property-decorator';
// @ts-ignore
import MoonLoader from 'vue-spinner/src/MoonLoader';
import store from './../store';
import { routes } from './../router';
import axios, { AxiosResponse } from 'axios';
import UserService from './../services/user-service';

@Component({
  components: {
    'moon-loader': MoonLoader
  },
  props: {}
})
export default class Root extends Vue {
  public showDrawer: boolean = false;
  private userService: UserService;

  constructor() {
    super();
    this.userService = new UserService();
  }

  get appName() {
    const el = document.querySelector('meta[name="app-name"]');
    return el?.getAttribute('content');
  }

  async mounted() {
    await this.fetchUser();
  }

  public async fetchUser() {
    const user = await this.userService.getLoggedInUser();
    store.commit('setUser', user);
  }

  public toggleShowDrawer() {
    this.showDrawer = !this.showDrawer;
  }

  public get routes() {
    return routes.filter(route => route.icon);
  }

  public get showLoader() {
    return store.getters.getShowLoader;
  }

  public async logout() {
    await axios.post('/logout');
    window.location.href = '/';
  }

  public redirect(link: string) {
    if (this.$router.currentRoute.path != link) {
      this.$router.push(link);
    }
    this.showDrawer = false;
  }

  public get breadcrumbs() {
    return store.getters.getBreadcrumbs;
  }

  public get callToAction() {
    return store.getters.getCallToAction;
  }

  public get snackbar() {
    return store.getters.getSnackbar;
  }
}
</script>
