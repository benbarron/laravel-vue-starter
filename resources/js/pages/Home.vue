<template>
  <div class="container">
    <div class="row d-flex justify-content-center text-center">
      <div>
        <h2>{{ title }}</h2>
        <h2>{{ num }}</h2>
        <button @click="decrement()" class="btn btn-sm btn-secondary mx-3">
          Dec
        </button>
        <button @click="increment()" class="btn btn-sm btn-primary mx-3">
          Inc
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';

@Component
export default class Home extends Vue {
  public title: string = 'Hello world';
  public num: number = 0;

  increment() {
    this.num += 1;
  }

  decrement() {
    this.num -= 1;
  }
}
</script>
