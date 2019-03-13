<template>
    <div>
        <b-alert :show="hasError" variant="danger">{{ errorMessage }}</b-alert>
        <b-table selectable :select-mode="selectMode" @row-selected="rowSelected" striped hover :items="items" :fields="fields" />
    </div>
</template>

<script>
export default {
    props: ['user'],

    data() {
        return {
            fields: [
                { 
                    key : 'repository',
                    sortable: true
                },
                { 
                    key : 'number_of_stars',
                    sortable : true
                }],
            items: [],
            hasError: false,
            errorMessage: '',
            selectMode: 'single'
        }
    },

    created() {
        this.retrieveRepositories();
    },

    methods: {
        async retrieveRepositories() {
            try { 
                const resp = await axios.get(`/api/users/${this.user.id}/repositories`);
                console.log(resp);
                if (resp.data.success) {
                  console.log(resp);
                    resp.data.data.forEach(repository => {
                        this.items.push({repository: repository.full_name,  number_of_stars: repository.stargazers_count});
                    });
                }
            } 
            catch (error){
                this.hasError = true;
                this.errorMessage = error;
            }
        },
        rowSelected(selectedItems) {
          if(selectedItems.length > 0)
            this.$emit('selectedRepository', selectedItems[0].repository);
        }

    }
}
</script>
