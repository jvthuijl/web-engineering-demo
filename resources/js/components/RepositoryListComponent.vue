<template>
  <div>
    <b-table striped hover :items="items" :fields="fields" />
  </div>
</template>

<script>
  export default {
    data() {
      return {
        // Note `isActive` is left out and will not appear in the rendered table
        fields: ['repository', 'user', 'number_of_stars'],
        items: [
            {repository: 'Test', user: 'Jasper', number_of_stars: 10},
            {repository: 'Test', user: 'Julius', number_of_stars: 10},
            {repository: 'Test', user: 'Noam', number_of_stars: 10}
        ]
      }
    }
  }
</script>
