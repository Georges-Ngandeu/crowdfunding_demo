/**
 * Created by Georges on 27/08/2020.
 */
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

import Vue from 'vue';
import LoginForm from './LoginForm.vue';

new Vue({
    el: '#loginForm',
    render(h){
        return h(LoginForm, {props: {
            id: this.projectId
        }})
    },
    beforeMount: function() {
        this.projectId = this.$el.attributes['data-project'].value;
    }
});
