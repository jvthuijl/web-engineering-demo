<template>
  <div>
    <b-table striped hover :items="items" :fields="fields" />
  </div>
</template>

<script>
  export default {
    props: ['user'],

    data() {
      return {
        fields: ['repository', 'user', 'number_of_stars'],
        items: [
            {isActive: true, repository: 'Test', user: 'Julius', number_of_stars: 10},
            {repository: 'Test', user: 'Noam', number_of_stars: 10}
        ]
      }
    },

    created() {
      console.log(this.user);
      this.items.push({repository: 'Asdasd', user: this.user.name, number_of_stars: 10});
    }
  }
</script>
