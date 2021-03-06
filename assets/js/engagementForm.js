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
import EngagementForm from './EngagementForm.vue';
import vueCountryRegionSelect from 'vue-country-region-select'

Vue.use(vueCountryRegionSelect);

new Vue({
    el: '#engagementForm',
    render(h){
        return h(EngagementForm, {props: {
            id: this.userId,
            pid: this.projectId
        }})
    },
    beforeMount: function() {
        this.userId = this.$el.attributes['data-user'].value;
        this.projectId = this.$el.attributes['data-project'].value;
    }
});
