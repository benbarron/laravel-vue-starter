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
                Update User
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="updateUser()" :disabled="!name || !email">
                    Update
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-text-field v-model="name" label="Full name" type="text" single-line hide-details></v-text-field>
                <v-text-field v-model="email" label="Email" type="email" single-line hide-details></v-text-field>
                <v-switch v-model="role" :label="`Is Admin`"></v-switch>
            </v-card-text>
        </v-card>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import UserService from '../services/user-service';
import store from './../store';

@Component({
    components: {}
})
export default class UsersEdit extends Vue {
    private userService: UserService;
    public id: string = this.$router.currentRoute.params.id;
    public name: string = '';
    public email: string = '';
    public role: number = 0;

    constructor() {
        super();
        this.userService = new UserService();
    }

    async mounted() {
        this.configureBreadcrumbs();
        await this.fetchUser();
    }

    async fetchUser() {
        const user: any = await this.userService.getUserById(this.id);
        this.name = user.name;
        this.email = user.email;
        this.role = user.role;
    }

    async updateUser() {
        try {
            const res = await this.userService.updateUser(this.id, {
                name: this.name,
                email: this.email,
                role: this.role
            });
            this.success(res.message);
            await this.$router.push('/users');
        } catch (e) {
            this.error(e.message);
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

    configureBreadcrumbs() {
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
                href: this.$router.currentRoute.path,
                text: this.$router.currentRoute.params.id
            }
        ]);
    }
}
</script>
