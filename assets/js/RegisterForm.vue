<template>
    <div class="card">
        <h5 class="card-header">Bien vouloir remplir ce formulaire pour souscrire</h5>
        <div class="card-body">
            <div class="bg-danger text-white my-2 p-2" v-if="serverErrors">
                <h5>Une erreur est survenue sur le système, veiller contacter l'administrateur</h5>
                <!--<pre v-text="serverErrors"></pre>-->
            </div>
            <div class="bg-danger text-white my-2 p-2" v-if="errors">
                <h5>Les problèmes suivants ont été identifiés:</h5>
                <ul>
                    <template v-for="(errors) in validationErrors">
                        <li v-for="error in errors" v-bind:key="error">{{error}}</li>
                    </template>
                </ul>
            </div>
            <!--<div class="bg-danger text-white my-2 p-2" v-if="!invalidCountryNationality">-->
                <!--<h5>Les problèmes suivants ont été identifiés:</h5>-->
                <!--<ul>-->
                    <!--<li>Pour souscrire, il faut etre camerounais ou résider au cameroun</li>-->
                <!--</ul>-->
            <!--</div>-->
            <fieldset class="border p-2 m-2 form-border">
                <legend  class="w-auto form-border form-title-text">Informations Personne morale</legend>
                <div class="form-row">
                    <input class="form-control checkbox-custom" type="checkbox"  v-model="moralePersonCheck"  @click="moralePersonCheckLogic">
                    <label class="form-check-label checkbox-text">Etes vous une personne morale ?</label>
                </div>
                <div class="form-row" v-if="moralePersonCheck">
                    <div class="form-group col-md-6">
                        <label>Nom personne morale</label>
                        <input class="form-control" type="text" placeholder="Personne morale" v-model="moralePersonName">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nom representant personne morale</label>
                        <input class="form-control" type="text" placeholder="Nom representant personne morale" v-model="moralePersonRepresentant">
                    </div>
                </div>
                <div class="form-row" v-if="moralePersonCheck">
                    <div class="form-group col-md-12">
                        <label>Prenom representant personne morale</label>
                        <input class="form-control" type="text" placeholder="Prénom representant personne morale" v-model="moralePersonRepresentantLastname">
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-2 m-2 form-border">
                <legend  class="w-auto form-border form-title-text">Nom et Prénom du souscripteur</legend>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nom</label>
                        <input class="form-control" type="text" placeholder="Nom" v-model="subscriberFirstName">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Prénom</label>
                        <input class="form-control" type="text" placeholder="Prénom" v-model="subscriberLastName">
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-2 m-2 form-border">
                <legend  class="w-auto form-border form-title-text">Date et lieu de naissance du souscripteur</legend>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Date de naissance</label>
                        <input class="form-control" type="datetime-local" placeholder="Date de naissance" v-model="subscriberBirthDate">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Lieu de naissance</label>
                        <input class="form-control" type="text" placeholder="Lieu de naissance"  v-model="subscriberBirthPlace">
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-2 m-2 form-border">
                <legend  class="w-auto form-border form-title-text">Informations CNI du souscripteur</legend>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>N° CNI/Passport</label>
                        <input class="form-control" type="text" placeholder="N° CNI/Passport" v-model="subscriberCniNumber">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Délivré le</label>
                        <input class="form-control" type="datetime-local" placeholder="Délivré le" v-model="subscriberCniDate">
                    </div>
                    <div class="form-group col-md-4">
                        <label>A</label>
                        <input class="form-control" type="text" placeholder="A" v-model="subscriberCniPlace">
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-2 m-2 form-border">
                <legend  class="w-auto form-border form-title-text">Nationalité, pays de résidence, langue</legend>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nationalité</label>
                        <country-select v-model="nationality" :country="nationality" topCountry="CM" placeholder="choisir votre nationalité" :countryName="true" />
                    </div>
                    <div class="form-group col-md-6">
                        <label>Pays de résidence</label>
                        <!--<input class="form-control" type="text" placeholder="Nom" v-model="subscriberNationality">-->
                        <country-select v-model="country" :country="country" topCountry="CM" placeholder="choisir votre pays de résidence" :countryName="true"/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Région de résidence</label>
                        <region-select v-model="region" :country="country" :region="region" placeholder="choisir votre région" :countryName="true"/>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Langue</label>
                        <select class="form-control" v-model="subscriberLanguage">
                            <option>Francais</option>
                            <option>Anglais</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-2 m-2 form-border">
                <legend  class="w-auto form-border form-title-text">Addresses du souscripteur</legend>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Téléphone 1 (Obligatoire)</label>
                        <input class="form-control" type="text" placeholder="Téléphone" v-model="subscriberPhone">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Téléphone 2 (Facultatif)</label>
                        <input class="form-control" type="text" placeholder="Téléphone 2" v-model="subscriberPhone2">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input class="form-control" type="email" placeholder="Email" v-model="subscriberEmail">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Genre</label>
                        <select class="form-control" v-model="subscriberGender">
                            <option>Masculin</option>
                            <option>Féminin</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Profession</label>
                        <input class="form-control" type="text" placeholder="Profession" v-model="subscriberProfession">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Ville</label>
                        <input class="form-control" type="text" placeholder="Ville" v-model="subscriberTown">
                    </div>
                </div>

                <fieldset class="border p-2 m-2 form-border">
                    <legend  class="w-auto form-border form-title-text">Situation matrimoniale et professionnelle</legend>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Situation matrimoniale</label>
                            <select class="form-control" v-model="subscriberMaritalStatus">
                                <option></option>
                                <option>Célibataire</option>
                                <option>Marié</option>
                                <option>Divorcé</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Situation professionnelle</label>
                            <select class="form-control" v-model="subscriberProfessionalStatus">
                                <option></option>
                                <option>Actif</option>
                                <option>A la retraite</option>
                            </select>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="border p-2 m-2 form-border">
                    <legend  class="w-auto form-border form-title-text">Uploader votre Passport/Cni Scanné</legend>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Uploader votre cni scannée</label>
                            <input class="form-control" type="file" ref="file" placeholder="Votre Cni scanné">
                        </div>
                    </div>
                </fieldset>

                <fieldset class="border p-2 m-2 form-border">
                    <legend  class="w-auto form-border form-title-text">Revenu estimatif et origine des fonds</legend>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Revenu estimatif</label>
                            <select class="form-control" v-model="subscriberRevenuEstimate">
                                <option></option>
                                <option>100000</option>
                                <option>200000</option>
                                <option>300000</option>
                                <option>400000</option>
                                <option>500000</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Origine des fonds</label>
                            <select class="form-control" v-model="subscriberRevenuOrigin">
                                <option>Salaire</option>
                                <option>Tontine</option>
                                <option>Epargne</option>
                                <option>Pret</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-check form-check-inline col-md-1">
                            <label></label>
                            <input class="form-control checkbox-custom" type="checkbox" @click="otherSubscriberRevenuOriginCheckLogic()">
                        </div>
                        <div class="form-group col-md-11" v-if="otherSubscriberRevenuOriginCheck">
                            <label>Autre origine des fonds</label>
                            <input class="" type="text" placeholder="Autres origine des fonds" v-model="subscriberOtherRevenuOrigin">
                        </div>
                        <div class="form-group col-md-11" v-if="!otherSubscriberRevenuOriginCheck">
                            <label>Autre origine des fonds</label>
                            <input class="" type="text" placeholder="Autres origine des fonds" readonly>
                        </div>
                    </div>

                </fieldset>

            </fieldset>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <button type="button" class="btn btn-primary btn-lg btn-block" @click="exactInfoAgreeLogic">
                        Je valide
                    </button>
                </div>
            </div>

            <loading :active.sync="isLoading"
                     :can-cancel="false"
                     :on-cancel="onCancel"
                     :is-full-page="fullPage"></loading>

            <div class="modal fade" id="validateEmailModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><h4>Validation addresse email par OTP</h4></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <fieldset class="border p-2 m-2 form-border">
                                <legend  class="w-auto form-border form-title-text">Validation Addresse Email</legend>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Entrer le code envoyé dans votre boite email pour valider</label>
                                        <input class="form-control" type="text" placeholder="Code de validation de l'email" v-model="otpValidationCode">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-lg btn-block" @click="saveUserInfo">
                                Je valide mon email
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="confirmPhoneNumberModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle"><h4>Confirmer votre numéro de téléphone</h4></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <fieldset class="border p-2 m-2 form-border">
                                <legend  class="w-auto form-border form-title-text">Confirmer votre numéro de téléphone</legend>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Un Otp vous a été envoyé à votre numéro de téléphone, veiller l'entrer</label>
                                        <input class="form-control" type="text" placeholder="Confirmer votre numéro de téléphone" v-model="subscriberOtp">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-lg btn-block" @click="confirmPhoneNumberLogic()">
                                Je valide
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="registerAgreementModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="registerAgreementTitle"><h4>Certification de la validité des informations</h4></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            En soumettant ce formulaire, je certifie que les informations entrées sont exactes
                        </div>
                        <div class="modal-footer">
                            <div class="form-row bankNumberBox agreeBox">
                                <input class="form-control checkbox-custom" type="checkbox"  v-model="exactInfoAgree" @click="validateEmail()">
                                <label class="form-check-label checkbox-text">Je certifie</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import {registerUser, saveSubscriberInfo, sendConfirmOtp, validateOtp} from './register.js';
    // Import component
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    import validation from "./validationRules";

    export default {
        props: ['id'],
        data() {
            return {
                moralePersonCheck: false,
                moralePersonName: "",
                moralePersonRepresentant: "",
                subscriberFirstName: "",
                subscriberLastName: "",
                subscriberBirthDate: "",
                subscriberBirthPlace: "",
                subscriberCniNumber: "",
                subscriberCniDate: "",
                subscriberCniPlace: "",
                subscriberPhone: "",
                subscriberPhone2: "",
                subscriberEmail: "",
                subscriberProfession: "",
                subscriberTown: "",
                file: "",
                subscriberMaritalStatus: "",
                subscriberProfessionalStatus: "",
                subscriberRevenuEstimate: "",
                subscriberRevenuOrigin:"",
                subscriberOtherRevenuOrigin: "",
                subscriberAgree: false,
                isLoading: false,
                fullPage: true,
                otpValidationCode: "",
                subscriberOtp: "",
                returnOtpCode: "",
                validationErrors: {},
                subscriberNationality: "",
                subscriberGender:"",
                moralePersonRepresentantLastname: "",
                serverError: "",
                otherSubscriberRevenuOriginCheck: false,
                country: '',
                region: '',
                nationality: '',
                exactInfoAgree: false,
                invalidCountryNationality: true,
                subscriberLanguage: ""
            }
        },
        components: {
            Loading
        },
        computed: {
            errors() {
                return Object.values(this.validationErrors).length > 0;
            },
            serverErrors(){
                return this.serverError;
            }
        },
        methods:{
            validate(propertyName, value) {
                let errors = [];
                Object(validation)[propertyName].forEach(v => {
                    if (!v.validator(value)) {
                        errors.push(v.message);
                    }
                });
                if (errors.length > 0) {
                    Vue.set(this.validationErrors, propertyName, errors);
                } else {
                    Vue.delete(this.validationErrors, propertyName);
                }
            },
            validateCountryNationality(){
                if(this.nationality !== "Cameroon" || this.country !== "Cameroon"){
                    this.invalidCountryNationality = false;
                }
            },
            moralePersonCheckLogic(){
                this.moralePersonCheck = !this.moralePersonCheck;
            },
            otherSubscriberRevenuOriginCheckLogic(){
                this.otherSubscriberRevenuOriginCheck = !this.otherSubscriberRevenuOriginCheck
            },
            userRegisterLogic(){
                this.isLoading = true;
                setTimeout(() => {
                    this.isLoading = false;
                    $('#validateEmailModalCenter').modal('hide');
                    console.log("Register succeed");
                    //console.log(this.id);
//                    this.file = this.$refs.file.files[0];
//                    let formData = new FormData();
//                    formData.append('file', this.file);

//                    registerUser(
//                        this.moralePersonName,
//                        this.moralePersonRepresentant,
//                        this.subscriberFirstName,
//                        this.subscriberLastName,
//                        this.subscriberBirthDate,
//                        this.subscriberBirthPlace,
//                        this.subscriberCniNumber,
//                        this.subscriberCniDate,
//                        this.subscriberCniPlace,
//                        this.subscriberPhone,
//                        this.subscriberEmail,
//                        this.subscriberProfession,
//                        this.subscriberTown,
//                        this.subscriberMaritalStatus,
//                        this.subscriberProfessionalStatus,
//                        this.subscriberRevenuEstimate,
//                        this.subscriberRevenuOrigin,
//                        this.id
//                    );
                },10000)
            },
            confirmPhoneNumberLogic(){
                this.isLoading = true;
                setTimeout(() => {
                    this.isLoading = false;
                    //validateOtp(this.subscriberOtp, this.subscriberPhone);
                    $('#confirmPhoneNumberModalCenter').modal('hide');
                    $('#validateEmailModalCenter').modal('show');
                },10000)
            },
            saveUserInfo(){
                this.isLoading = true;
                console.log(parseInt(this.otpValidationCode));
                if(parseInt(this.returnOtpCode) === parseInt(this.otpValidationCode)){
                    this.file = this.$refs.file.files[0];
                    let formData = new FormData();
                    formData.append('file', this.file);

                    saveSubscriberInfo(
                        this.moralePersonName,
                        this.moralePersonRepresentant,
                        this.subscriberFirstName,
                        this.subscriberLastName,
                        this.subscriberBirthDate,
                        this.subscriberBirthPlace,
                        this.subscriberCniNumber,
                        this.subscriberCniDate,
                        this.subscriberCniPlace,
                        this.subscriberPhone,
                        this.subscriberPhone2,
                        this.subscriberEmail,
                        this.subscriberProfession,
                        this.subscriberTown,
                        this.subscriberMaritalStatus,
                        this.subscriberProfessionalStatus,
                        this.subscriberRevenuEstimate,
                        this.subscriberRevenuOrigin,
                        this.subscriberOtherRevenuOrigin,
                        formData,
                        this.id,
                        this.subscriberNationality,
                        this.subscriberGender,
                        this.moralePersonRepresentantLastname,
                        this.country,
                        this.region,
                        this.subscriberLanguage
                    ).then(error => {
                        this.serverError = error;
                    });
                }
                setTimeout(() => {
                    this.isLoading = false;
                    console.log(parseInt(this.otpValidationCode));
                    if(parseInt(this.returnOtpCode) !== parseInt(this.otpValidationCode)){
                        alert("Votre code Otp n'est pas valide, veiller réessayer.");
                        $('#validateEmailModalCenter').modal('hide');
                    }
                },5000)
            },
            onCancel() {
                console.log('User cancelled the loader.')
            },
            validateAll() {
                this.validate("phone", this.subscriberPhone);
                this.validate("firstName", this.subscriberFirstName);
                this.validate("lastName", this.subscriberLastName);
                this.validate("Email",  this.subscriberEmail);
                this.validate("birthPlace",  this.subscriberBirthPlace);
                this.validate("cniNumber",  this.subscriberCniNumber);
                this.validate("cniPlace",  this.subscriberCniPlace);
                this.validate("profession",  this.subscriberProfession);
                this.validate("town",  this.subscriberTown);
                this.validateCountryNationality();

                //console.log(this.nationality === "Cameroon");
                //console.log(this.country === "Cameroon");
                return this.errors;
            },
            validateEmail(){
                if (!this.validateAll()) {
                    $('#registerAgreementModalCenter').modal('hide');
                    this.isLoading = true;
                    sendConfirmOtp(this.subscriberEmail, this.subscriberEmail).then(data => {
                        this.returnOtpCode =  data.Otp;
                        console.log(this.returnOtpCode);
                    }, (error) => {
                        console.log(error);
                    });
                    setTimeout(() => {
                        this.isLoading = false;
                        $('#validateEmailModalCenter').modal('show');
                    },5000);

                }
            },
            exactInfoAgreeLogic(){
                if (!this.validateAll()) {
                    $('#registerAgreementModalCenter').modal('show');
                }
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

    .checkbox-custom{
        width: 1rem !important;
        margin-left: 1rem !important;
    }

    .checkbox-text{
        margin-left: 0rem !important;
        margin-top: 0.8rem;
    }

    .bankNumberBox{
        margin-top: -1rem;
    }

    .agreeBox{
        margin-right: 1rem;
    }
</style>