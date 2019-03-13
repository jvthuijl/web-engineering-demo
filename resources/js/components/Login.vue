<template>
    <div class="row">
        <div class="col">
            <b-jumbotron header="Favorite Repos" lead="Creating notes on your favorite repositories has never been so easy!">
                <p>
                    <b-button :disabled="isVerifying" v-on:click='login()' size="lg" variant="primary">Login to GitHub</b-button>
                </p>
                <b-alert :show="isVerifying">Verifying... <b-spinner/></b-alert>
                <b-alert :show="hasError" variant="danger">{{ errorMessage }}</b-alert>
            </b-jumbotron>
        </div>
    </div>
</template>

<script>
export default {
    methods : {
        async login() {
            const resp = await axios.get('/api/auth/login', response => alert('logged in'));
            if (resp.data.success) {
                window.location.href = resp.data.data.redirect_url;
            }
        },
        showError(error)
        {
            this.hasError = true;
            this.errorMessage = error;
        }

    },
    data() {
        return {
            hasError : false,
            errorMessage : "",
            isVerifying: false
        }
    },
    async created() {
            const urlParams = new URLSearchParams(window.location.search);
            const code = urlParams.get('code');

            const windowUrl = window.location.toString();
            window.history.replaceState({}, document.title, windowUrl.substr(0, windowUrl.indexOf('?')));

            if (code) {
                try {
                    this.isVerifying = true;
                    const resp = await axios.post('/api/auth/verify', {code: code});

                    if (resp.data.success) {
                        axios.defaults.headers.common = {
                            'Authorization': 'Bearer ' + resp.headers.authorization
                        };
                        this.$emit('authenticated', resp.data.data.user);
                    }

                } 
                catch (error) {
                    this.showError(error);
                }
            }

            this.isVerifying = false;
        }
}
</script>
