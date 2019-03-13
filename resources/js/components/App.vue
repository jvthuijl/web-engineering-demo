<template>
    <div>
        <login v-if="authenticatedUser === null" @authenticated="userAuthenticated"></login>
        <div v-else class="row">
            <div class="col-6">
                <h1>Your favorites</h1>
                <repository-list :user="authenticatedUser" @selectedRepository="setSelectedRepository"></repository-list>
            </div>
            <div class="col-6">
                <repository-comment :repository="selectedRepository"></repository-comment>
            </div>
        </div>
    </div>
</template>

<script>
    import Login from './Login';
    import RepositoryList from './RepositoryList';
    import RepositoryComment from './RepositoryComment';

    export default {
        name: 'App',
        components: {Login, RepositoryList, RepositoryComment},
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
            }
        }
    }
</script>