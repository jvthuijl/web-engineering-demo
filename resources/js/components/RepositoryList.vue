<template>
    <div>
        <b-alert :show="errorMessage !== null" variant="danger">{{ errorMessage }}</b-alert>
        <b-table selectable
                 select-mode="single"
                 @row-selected="rowSelected"
                 :items="items"
                 :fields="fields"
                 :busy="isFetching"
                 striped hover>
            <div slot="table-busy" class="text-center text-info">
                <b-spinner class="align-middle"/>
            </div>
        </b-table>
    </div>
</template>

<script>
    export default {
        props: ['user'],

        data() {
            return {
                fields: [
                    {
                        key: 'repository',
                        sortable: true
                    },
                    {
                        key: 'number_of_stars',
                        sortable: true
                    }],
                isFetching: false,
                repositories: [],
                errorMessage: null
            }
        },

        created() {
            this.retrieveRepositories();
        },

        computed: {
            items() {
                let items = [];
                this.repositories.forEach(repository => {
                    items.push({
                        id: repository.id,
                        repository: repository.full_name,
                        number_of_stars: repository.stargazers_count
                    });
                });
                return items;
            }
        },

        methods: {
            async retrieveRepositories() {
                try {
                    this.errorMessage = null;
                    this.isFetching = true;
                    const resp = await axios.get(`/api/users/${this.user.id}/repositories`);
                    if (resp.data.success) {
                        this.repositories = resp.data.data;
                    }
                } catch (error) {
                    this.errorMessage = error;
                }
                this.isFetching = false;
            },

            rowSelected(selectedItems) {
                if (selectedItems.length > 0) {
                    this.$emit('selectedRepository', this.repositories.find((repo) => repo.id === selectedItems[0].id));
                }
            }

        }
    }
</script>
