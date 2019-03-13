<template>
    <div>
        <h3 class="repo-title">{{ repository.full_name }}</h3>

        <div style="margin-bottom: 10px;">
            <p v-if="isFetching" class="text-center text-info">
                <b-spinner class="align-middle" />
            </p>
            <b-card-group v-else deck v-for="i in Math.ceil(notes.length / 2)" :key="i">
                <b-card v-for="note in notes.slice((i - 1) * 2, i * 2)" :key="note.id">
                    <b-card-text>{{ note.content }}</b-card-text>
                    <div slot="footer" class="text-center">
                        <b-button type="button" variant="danger" @click="deleteNote(note)">Delete</b-button>
                    </div>
                </b-card>
            </b-card-group>
        </div>

        <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
            <b-form-group>
                <b-form-textarea
                        id="textarea"
                        v-model="newNoteText"
                        placeholder="Enter something..."
                        rows="3"
                        max-rows="6"
                />
            </b-form-group>
            <b-button type="submit" variant="primary" :disabled="isSaving">
                <b-spinner v-if="isSaving"/>
                <span v-else>Add</span>
            </b-button>
            <b-button type="reset" variant="danger">Reset</b-button>
        </b-form>
        <b-alert :show="errorMessage !== null" variant="danger">{{ errorMessage }}</b-alert>
    </div>
</template>

<script>
    export default {
        props: ['repository'],

        data() {
            return {
                newNoteText: '',
                notes: [],
                isFetching: false,
                isSaving: false,
                errorMessage: null,
            }
        },

        created() {
            this.initialize();
        },

        watch: {
            repository() {
                this.initialize();
            }
        },

        methods: {
            initialize() {
                this.fetchNotes();
                this.onReset();
            },
            async fetchNotes() {
                this.notes = [];
                this.isFetching = true;

                const resp = await axios.get(`/api/repositories/${this.repository.id}/notes`).finally(() => this.isFetching = false);
                if (resp.data.success) {
                    this.notes = resp.data.data;
                }
            },
            async onSubmit() {
                const noteText = this.newNoteText;
                this.onReset();

                try {
                    this.isSaving = true;
                    let resp = await axios.post(`/api/repositories/${this.repository.id}/notes`, {
                        content: noteText
                    }).finally(() => this.isSaving = false);

                    if (resp.data.success) {
                        this.notes.push(resp.data.data);
                    }
                } catch (error) {
                    this.errorMessage = error;
                }
            },
            async deleteNote(note) {
                if (!confirm('Are you sure?')) {
                    return;
                }

                await axios.delete(`/api/repositories/${this.repository.id}/notes/${note.id}`);
                this.notes = this.notes.filter(n => n.id !== note.id);
            },
            onReset() {
                this.newNoteText = '';
            }
        }

    }
</script>
<style scoped>
    .repo-title {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>