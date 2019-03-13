<template>
    <div>
       <h1>{{repository}}</h1>
       <b-form v-if="repository !== null" @submit="onSubmit" @reset="onReset">
            <b-form-group>
                <b-form-textarea
                        id="textarea"
                        v-model="textarea"
                        placeholder="Enter something..."
                        rows="3"
                        max-rows="6"
                />
            </b-form-group>
            <b-button type="submit" variant="primary">Submit</b-button>
            <b-button type="reset" variant="danger">Reset</b-button>
        </b-form>
        <p v-else>
            Please select a repository on the left
        </p>
    </div>
</template>

<script>
export default {
    props: ['repository'],

    data() {
        return {
            textarea: "test"
        }
    },

    watch: {
        repository(repository) {
            this.textarea = repository;
        }
    },

    methods : 
    {
        onSubmit(evt) {
            evt.preventDefault()
            alert(JSON.stringify(this.repository))
        },
        onReset(evt) {
            evt.preventDefault()
            /* Reset our form values */
            this.textarea = ''
      }
    }

}
   
</script>
