/**
 * Created by Georges on 25/08/2020.
 */
// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

import Vue from 'vue';
import RegisterForm from './RegisterForm.vue';
import vueCountryRegionSelect from 'vue-country-region-select'

Vue.use(vueCountryRegionSelect);

new Vue({
    el: '#registerForm',
    render(h){
            return h(RegisterForm, {props: {
                id: this.projectId,
            }
        })
    },
    beforeMount: function() {
        this.projectId = this.$el.attributes['data-project'].value;
    }
});
