<style scoped>
.v-card-body {
  padding: 25px;
}
.v-input {
  margin-bottom: 20px;
}
</style>

<template>
  <div class="container">
    <v-card>
      <v-card-title>
        Create User
        <v-spacer></v-spacer>
        <v-btn color="primary" @click="createUser()" :disabled="!name || !email || !password">
          Submit
        </v-btn>
      </v-card-title>
      <v-card-text>
        <v-text-field v-model="name" label="Full name" type="text" single-line hide-details></v-text-field>
        <v-text-field v-model="email" label="Email" type="email" single-line hide-details></v-text-field>
        <v-text-field
          v-model="password"
          label="Password"
          type="password"
          single-line
          hide-details
        ></v-text-field>
      </v-card-text>
    </v-card>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import UserService from './../services/user-service';
import store from './../store';

@Component({
  components: {}
})
export default class UsersCreate extends Vue {
  public name: string = '';
  public email: string = '';
  public password: string = '';
  private userService: UserService;

  constructor() {
    super();
    this.userService = new UserService();
  }

  mounted() {
    this.configureBreadCrumbs();
  }

  async createUser() {
    const { name, email, password } = this;
    if (!name || !email || !password) {
      return this.error('Please enter all fields');
    }
    try {
      const res = await this.userService.createUser({
        name: this.name,
        email: this.email,
        password: this.password
      });
      this.success(res.message);
      this.$router.push('/users');
    } catch (err) {
      this.error(err.message);
    }
  }

  error(message: string) {
    store.commit('setSnackbar', {
      color: '#aa0000',
      message: message,
      timeout: 5000,
      show: true
    });
  }

  success(message: string) {
    store.commit('setSnackbar', {
      color: '#27ae60',
      message: message,
      timeout: 5000,
      show: true
    });
  }

  configureBreadCrumbs() {
    store.commit('setCallToAction', null);

    store.commit('setBreadcrumbs', [
      {
        href: '/home',
        text: 'Home'
      },
      {
        href: '/users',
        text: 'Users'
      },
      {
        href: '/users/create',
        text: 'Create User'
      }
    ]);
  }
}
</script>
