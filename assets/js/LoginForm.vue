<template>
    <div class="card">
        <h5 class="card-header">Avez vous déja souscris à un projet sur notre plateforme ?</h5>
        <div class="card-body">
            <div class="bg-danger text-white my-2 p-2" v-if="serverErrors">
                <h5>Une erreur est survenue sur le système, veiller contacter l'administrateur</h5>
                <!--<pre v-text="serverErrors"></pre>-->
            </div>
            <div class="bg-danger text-white my-2 p-2" v-if="errors">
                <h3>Vous n'etes pas enregistré dans notre système</h3>
            </div>
            <fieldset class="border p-2 m-2 form-border">
                <legend  class="w-auto form-border form-title-text">Entrer votre email si c'est le cas</legend>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Email</label>
                        <input class="form-control" type="email" placeholder="Email" v-model="userEmail">
                    </div>
                </div>
            </fieldset>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <button type="button" class="btn btn-primary btn-lg btn-block" @click="checkEmail()">
                        Oui
                    </button>
                </div>
                <div class="form-group col-md-6">
                    <button type="button" class="btn btn-primary btn-lg btn-block" @click="goToRegister()">
                        Non
                    </button>
                </div>
            </div>

            <loading :active.sync="isLoading"
                     :can-cancel="false"
                     :on-cancel="onCancel"
                     :is-full-page="fullPage"></loading>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    // Import component
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    import {checkEmail, goToRegisterUser} from './register.js';


    export default {
        props: ['id'],
        data() {
            return {
                userEmail: "",
                isLoading: false,
                fullPage: true,
                serverError: ""
            }
        },
        components: {
            Loading
        },
        computed: {
            errors() {
            },
            serverErrors(){
                return this.serverError;
            }
        },
        methods:{
            onCancel() {
                console.log('User cancelled the loader.')
            },
            checkEmail(){
                this.isLoading = true;
                let loginResult = checkEmail(this.userEmail, this.id).then(error => {
                    this.serverError = error;
                });
                setTimeout(() => {
                    this.isLoading = false;
                    console.log(loginResult);
                },5000)
            },
            goToRegister(){
                this.isLoading = true;
                setTimeout(() => {
                    this.isLoading = false;
                    goToRegisterUser(this.id)
                },5000)
            }
        }
    };

</script>

<style>
    legend.form-border {
        width:inherit; /* Or auto */
        padding:0 10px; /* To give a bit of padding on the left and right */
        border-bottom:none;
    }
    .form-title-text{
        font-weight: 500;
    }
</style>