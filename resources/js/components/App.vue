<template>
    <div>
        <login v-if="authenticatedUser === null" @authenticated="userAuthenticated"></login>
        <div v-else class="row">
            <div class="col-md-6">
                <h1>Your favorites</h1>
                <p>
                    <b-button variant="warning" @click="logout">Log out</b-button>
                </p>
                <repository-list :user="authenticatedUser" @selectedRepository="setSelectedRepository"></repository-list>
            </div>
            <div class="col-md-6">
                <repository-note v-if="selectedRepository" :repository="selectedRepository"></repository-note>
                <p v-else class="text-center">
                    Please select a repository.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    import Login from './Login';
    import RepositoryList from './RepositoryList';
    import RepositoryNote from './RepositoryNote';

    export default {
        name: 'App',
        components: {Login, RepositoryList, RepositoryNote},
        data() {
            return {
                authenticatedUser: null,
                selectedRepository: null
            }
        },
        methods: {
            userAuthenticated(user) {
                this.authenticatedUser = user;
            },
            setSelectedRepository(repository) {
                this.selectedRepository = repository;
            },
            logout() {
                this.authenticatedUser = null;
                axios.post('/api/auth/logout');
                axios.defaults.headers.common = {};
            }
        }
    }
</script>