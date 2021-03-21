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
        :headers="user.role === 1 ? authTableHeaders : defaultTableHeaders"
        :search="search"
        :items="users"
        :items-per-page="5"
        class="elevation-1"
      >
      </v-data-table>
    </v-card>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import store from './../store';
import UserService from '../services/user-service';
import firebase from 'firebase';

@Component
export default class Users extends Vue {
  private user: any = store.getters.getUser;
  private userService: UserService;
  public search: string = '';
  public users: any[] = [];

  public defaultTableHeaders = [
    {
      text: 'Name',
      align: 'start',
      sortable: false,
      value: 'name',
    },
    {
      text: 'Email',
      align: 'start',
      sortable: false,
      value: 'email',
    },
  ];

  public authTableHeaders = [
    {
      text: 'Id',
      align: 'start',
      sortable: false,
      value: 'id',
    },
    {
      text: 'Name',
      align: 'start',
      sortable: false,
      value: 'name',
    },
    {
      text: 'Email',
      align: 'start',
      sortable: false,
      value: 'email',
    },
    {
      text: 'Created',
      align: 'start',
      sortable: false,
      value: 'created_at',
    },
    {
      text: 'Updated',
      align: 'start',
      sortable: false,
      value: 'updated_at',
    },
    {
      text: 'User Type',
      align: 'start',
      sortable: false,
      value: 'role',
    },
  ];

  constructor() {
    super();
    this.userService = new UserService();
  }

  async mounted() {
    this.user = store.getters.getUser;
    this.configureBreadcrumbs();
    await this.fetchUsers();
  }

  async fetchUsers() {
    const users: any[] = await this.userService.getAllUsers();
    this.users = users.map((user: any) => ({
      ...user,
      role: user.role ? 'Admin' : 'Non Admin',
    }));
  }

  async handleRowClick(user: any) {
    if (store.getters.getUser.role === 1) {
      this.$router.push(`/users/edit/${user.id}`);
    } else {
      const db = firebase.firestore();
      const invite = db.collection('invites').doc();
      const call = db.collection('calls').doc();
      await invite.set({
        from_id: store.getters.getUser.id,
        from_email: store.getters.getUser.email,
        to_id: user.id,
        to_email: user.email,
        call_id: call.id,
      });
      this.$router.push(`/meeting?id=${call.id}&j=f`);
    }
  }

  invite() {}

  configureBreadcrumbs() {
    if (this.user.role === 1) {
      store.commit('setCallToAction', {
        text: 'Create User',
        href: '/users/create',
      });
    }

    store.commit('setBreadcrumbs', [
      {
        href: '/home',
        text: 'Home',
      },
      {
        href: '/users',
        text: 'Users',
      },
    ]);
  }
}
</script>
