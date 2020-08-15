<template>
  <div class="container">
    <v-card>
      <v-card-title>
        Users
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table
        @click:row="handleRowClick"
        :headers="tableHeaders"
        :search="search"
        :items="users"
        :items-per-page="5"
        class="elevation-1"
      ></v-data-table>
    </v-card>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import axios, { AxiosResponse } from 'axios';
import store from './../store';
import UserService from '../services/user-service';

@Component
export default class Users extends Vue {
  private userService: UserService;
  public search: string = '';
  public users: any[] = [];
  public tableHeaders = [
    {
      text: 'Id',
      align: 'start',
      sortable: false,
      value: 'id'
    },
    {
      text: 'Name',
      align: 'start',
      sortable: false,
      value: 'name'
    },
    {
      text: 'Email',
      align: 'start',
      sortable: false,
      value: 'email'
    },
    {
      text: 'Date Created',
      align: 'start',
      sortable: false,
      value: 'created_at'
    }
  ];

  constructor() {
    super();
    this.userService = new UserService();
  }

  async mounted() {
    this.configureBreadcrumbs();
    await this.fetchUsers();
  }

  async fetchUsers() {
    const users = await this.userService.getAllUsers();
    this.users = users.map((user: any) => ({
      ...user,
      created_at: new Date(user.created_at).toLocaleString()
    }));
  }

  handleRowClick(user: any) {
    this.$router.push(`/users/edit/${user.id}`);
  }

  configureBreadcrumbs() {
    store.commit('setCallToAction', {
      text: 'Create User',
      href: '/users/create'
    });

    store.commit('setBreadcrumbs', [
      {
        href: '/home',
        text: 'Home'
      },
      {
        href: '/users',
        text: 'Users'
      }
    ]);
  }
}
</script>
