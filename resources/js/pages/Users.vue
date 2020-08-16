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
            text: 'Created',
            align: 'start',
            sortable: false,
            value: 'created_at'
        },
        {
            text: 'Updated',
            align: 'start',
            sortable: false,
            value: 'updated_at'
        },
        {
            text: 'Role(1=admin)',
            align: 'start',
            sortable: false,
            value: 'role'
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
        this.users = await this.userService.getAllUsers();
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
