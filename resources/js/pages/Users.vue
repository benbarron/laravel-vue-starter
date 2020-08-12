<template>
  <div>
    <button class="btn btn-primary" @click="fetchUsers">Fetch Users</button>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import axios, { AxiosResponse } from 'axios';

@Component
export default class Users extends Vue {
  async fetchUsers() {
    const url: string = 'https://jsonplaceholder.typicode.com/users';
    const res: AxiosResponse<any> = await axios.get(url);
    console.log(res.data);
  }
}
</script>
