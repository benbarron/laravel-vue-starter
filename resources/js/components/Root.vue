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
      <v-toolbar-title>Laravel</v-toolbar-title>
    </v-app-bar>

    <v-main>
      <v-divider></v-divider>
      <div v-if="showLoader" class="wask_loader bg_half_transparent">
        <moon-loader color="red"></moon-loader>
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
// @ts-ignore
import MoonLoader from 'vue-spinner/src/MoonLoader';
import store from './../store';
import { routes } from './../router';
import axios from 'axios';

@Component({
  components: {
    'moon-loader': MoonLoader
  }
})
export default class Root extends Vue {
  public showDrawer: boolean = false;

  public toggleShowDrawer() {
    this.showDrawer = !this.showDrawer;
  }

  public get routes() {
    return routes;
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
  }
}
</script>
