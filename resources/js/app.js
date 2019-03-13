
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import App from './components/App';

window.Vue = require('vue');
Vue.use(BootstrapVue);

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    data : {
        authenticated : false
    },
    methods: {
        userAuthenticated(user) {
            this.authenticated = true;
            console.log(user);
        }
    }
});
