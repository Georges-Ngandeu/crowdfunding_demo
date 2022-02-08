<template>
    <div class="card">
        <h5 class="card-header">Remplir ce formulaire pour souscrire au projet</h5>
        <div class="card-body">
            <div class="bg-danger text-white my-2 p-2" v-if="serverErrors">
                <h5>Une erreur est survenue sur le système, veiller contacter l'administrateur</h5>
                <!--<pre v-text="serverErrors"></pre>-->
            </div>
            <fieldset class="border p-2 m-2 form-border">
                <legend  class="w-auto form-border form-title-text">Informations Personne morale</legend>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nom personne morale</label>
                        <input class="form-control" type="text" placeholder="Personne morale" readonly v-model="subscriberMoralePersonName">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nom representant personne morale</label>
                        <input class="form-control" type="text" placeholder="Nom Representant personne morale" readonly v-model="subscriberMoralePersonRepName">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Prénom representant personne morale</label>
                        <input class="form-control" type="text" placeholder="Prénom Representant personne morale" readonly v-model="subscriberMoralePersonRepLastName">
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-2 m-2 form-border">
                <legend  class="w-auto form-border form-title-text">Nom et Prénom du souscripteur</legend>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nom</label>
                        <input class="form-control" type="text" placeholder="Nom" v-model="subscriberFirstName" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Prénom</label>
                        <input class="form-control" type="text" placeholder="Prénom" v-model="subscriberLastName" readonly>
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-2 m-2 form-border">
                <legend  class="w-auto form-border form-title-text">Date et lieu de naissance du souscripteur</legend>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Date de naissance</label>
                        <input class="form-control" type="text" placeholder="Date de naissance" readonly v-model="subscriberBirthDate">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Lieu de naissance</label>
                        <input class="form-control" type="text" placeholder="Lieu de naissance" readonly v-model="subscriberBirthPlace">
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-2 m-2 form-border">
                <legend  class="w-auto form-border form-title-text">Informations CNI du souscripteur</legend>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>N° CNI/Passport</label>
                        <input class="form-control" type="text" placeholder="N° CNI/Passport" readonly v-model="subscriberCniNumber">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Délivré le</label>
                        <input class="form-control" type="datetime-local" placeholder="Délivré le" readonly v-model="subscriberCniDate">
                    </div>
                    <div class="form-group col-md-4">
                        <label>A</label>
                        <input class="form-control" type="text" placeholder="A" readonly v-model="subscriberCniPlace">
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-2 m-2 form-border">
                <legend  class="w-auto form-border form-title-text">Nationalité, pays de résidence, langue</legend>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nationalité</label>
                        <input class="form-control" v-model="nationality"   readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Pays de résidence</label>
                        <!--<input class="form-control" type="text" placeholder="Nom" v-model="subscriberNationality">-->
                        <input class="form-control" v-model="country" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Région de résidence</label>
                        <input class="form-control" v-model="region" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Langue</label>
                        <input  class="form-control" v-model="subscriberLanguage" readonly>
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-2 m-2 form-border">
                    <legend  class="w-auto form-border form-title-text">Addresses du souscripteur</legend>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Téléphone 1 (Obligatoire)</label>
                            <input class="form-control" type="text" placeholder="Téléphone" v-model="subscriberPhone" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Téléphone 2 (Facultatif)</label>
                            <input class="form-control" type="text" placeholder="Téléphone 2" v-model="subscriberPhone2" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input class="form-control" type="email" placeholder="Email" v-model="subscriberEmail" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Genre</label>
                            <input class="form-control" v-model="subscriberGender" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Profession</label>
                            <input class="form-control" type="text" placeholder="Profession" v-model="subscriberProfession" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Ville</label>
                            <input class="form-control" type="text" placeholder="Ville" v-model="subscriberTown" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Profession</label>
                            <input class="form-control" type="text" placeholder="Profession" readonly v-model="subscriberProfession">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Ville</label>
                            <input class="form-control" type="text" placeholder="Ville" readonly v-model="subscriberTown" readonly>
                        </div>
                    </div>
            </fieldset>

            <fieldset class="border p-2 m-2 form-border">
                <legend  class="w-auto form-border form-title-text">Associer un partenaire</legend>
                <div class="form-row">
                    <input class="form-control checkbox-custom" type="checkbox"  v-model="subscriberPartnerCheck" @click="subscriberPartnerCheckLogic">
                    <label class="form-check-label checkbox-text">Souhaitez vous associer un partenaire ?</label>
                </div>

                <div class="form-row" v-if="subscriberPartnerCheck">
                    <div class="form-group col-md-6">
                        <label>Nom du partenaire</label>
                        <input class="form-control" type="text" placeholder="Nom du partenaire" v-model="subscriberPartnerFirstName">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Prénom du partenaire</label>
                        <input class="form-control" type="text" placeholder="Prénom du partenaire" v-model="subscriberPartnerLastName">
                    </div>
                </div>

                <div class="form-row" v-if="subscriberPartnerCheck">
                    <div class="form-group col-md-6">
                        <label>Téléphone</label>
                        <input class="form-control" type="text" placeholder="Téléphone" v-model="subscriberPartnerPhone">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input class="form-control" type="text" placeholder="Email" v-model="subscriberPartnerEmail">
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-2 m-2 form-border">
                <legend  class="w-auto form-border form-title-text">Choisir le nombre de part</legend>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Nombre de part</label>
                        <input class="form-control" type="text" placeholder="Nombre de part" v-model="subscriptionPartNumber">
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-2 m-2 form-border">
                <legend  class="w-auto form-border form-title-text">Compte pour recevoir vos rentes</legend>
                <div class="form-row" v-if="!subscriberBankCheck">
                    <input class="form-control checkbox-custom" type="checkbox"  v-model="subscriberMobileAccountCheck" @click="subscriberMobileAccountCheckLogic">
                    <label class="form-check-label checkbox-text">Souhaitez vous associer un compte mobile ?</label>
                </div>
                <div class="form-row" v-if="subscriberMobileAccountCheck">
                    <div class="form-group col-md-6">
                        <label>Moyen de paiement</label>
                        <select class="form-control" v-model="subscriberMobileAccountOperator">
                            <option>Afrikpay</option>
                            <option>Express Union Mobile Money</option>
                            <option>Mtn Mobile Money</option>
                            <option>Orange Money</option>
                            <option>Paypal</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Numéro Compte mobile</label>
                        <input class="form-control" type="text" placeholder="Compte mobile" v-model="subscriberMobileAccountNumber">
                    </div>
                </div>
                <div class="form-row bankNumberBox" v-if="!subscriberMobileAccountCheck">
                    <input class="form-control checkbox-custom" type="checkbox"  v-model="subscriberBankCheck" @click="subscriberBankCheckLogic">
                    <label class="form-check-label checkbox-text">Souhaitez vous associer un compte bancaire ?</label>
                </div>
                <div class="form-row" v-if="subscriberBankCheck">
                    <div class="form-group col-md-6">
                        <label>Nom de la banque</label>
                        <input class="form-control" type="text" placeholder="Nom de la banque" v-model="subscriptionBankName">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Code banque</label>
                        <input class="form-control" type="text" placeholder="Code banque" v-model="subscriptionBankCode">
                    </div>
                </div>
                <div class="form-row" v-if="subscriberBankCheck">
                    <div class="form-group col-md-6">
                        <label>RIB souscripteur</label>
                        <input class="form-control" type="text" placeholder="RIB souscripteur" v-model="subscriptionBankRib">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Code agence</label>
                        <input class="form-control" type="text" placeholder="Code agence" v-model="subscriptionBankAgence">
                    </div>
                </div>
                <div class="form-row" v-if="subscriberBankCheck">
                    <div class="form-group col-md-4">
                        <label>N° de compte</label>
                        <input class="form-control" type="text" placeholder="N° de compte" v-model="subscriptionBankAccountNumber">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Clé</label>
                        <input class="form-control" type="text" placeholder="Clé" v-model="subscriptionBankKey">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Iban</label>
                        <input class="form-control" type="text" placeholder="Iban" v-model="subscriptionBankIban">
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-2 m-2 form-border">
                <legend  class="w-auto form-border form-title-text">Ou avez vous entendu parler de ce projet ?</legend>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Ou avez vous entendu parler de ce projet</label>
                        <select class="form-control" v-model="subscriptionCampaignAwareness">
                            <option>Réseau sociaux</option>
                            <option>Recommendation</option>
                            <option>Google</option>
                            <option>Conférence</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <button type="button" class="btn btn-primary btn-lg btn-block" @click=subscribeLogic>
                        Je souscris à ce projet
                    </button>
                </div>
            </div>
        </div>

        <loading :active.sync="isLoading"
                 :can-cancel="false"
                 :on-cancel="onCancel"
                 :is-full-page="fullPage"></loading>

        <div class="modal fade" id="subscriptionAgreementModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"><h4>Conditions générales de ventes</h4></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        UBA Website Terms of Use
                        Thank you for visiting our website. This section contains the Terms of Use of this website. By accessing this website and any of its pages, you are agreeing to these Terms. UBA Plc reserves the right to amend the terms from time to time without notice.

                        Use of Information and Materials
                        The services and products offered on this website ("Services and Products") are for information purposes only. No persons gaining access to this website in any jurisdictions may treat any materials or information provided on this website as constituting an invitation to them to subscribe for the services, nor should they in any event use such services, unless in the relevant jurisdiction, the services could lawfully be made to them. Accordingly, nothing contained in this website shall constitute an offer or solicitation by anyone in any jurisdiction in which such offer or solicitation is not lawful. It is the responsibility of any person to inform themselves of and to observe all applicable laws and regulations of any relevant jurisdiction before they subscribe for the services. UBA Plc shall have the final determination of eligibility to subscribe to any of the services.
                        The information contained in these pages is not intended to provide professional advice and should not be relied upon in that regard. Persons accessing these pages are advised to obtain appropriate professional advice when necessary at all times in their respective jurisdiction.
                        Copyright and Trademarks
                        UBA Plc and its subsidiaries own the trademarks, logos and service marks displayed on this website. These may not be used without the written permission of the Bank or the party owning these. Materials on this site are protected by copyright. No part of these materials may be modified, reproduced, stored in a retrieval system, transmitted, copied, distributed or used in any other way for commercial or public purposes without the Bank’s prior written consent.

                        No Warranties
                        Whilst every care has been taken in preparing the information materials contained in this website, such information and materials are provided “as is” without warranty of any kind, either express or implied. In particular, no warranty regarding non-infringement, security, accuracy, fitness for a purpose or freedom from computer viruses is given in connection with such information and materials.
                    </div>
                    <div class="modal-footer">
                        <div class="form-row bankNumberBox agreeBox">
                            <input class="form-control checkbox-custom" type="checkbox"  v-model="subscriberAgree" @click="subscriberAgreeLogic">
                            <label class="form-check-label checkbox-text">J'accepte</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="mobileAccountModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><h4>Vérification du compte mobile des rentes</h4></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <fieldset class="border p-2 m-2 form-border">
                            <legend  class="w-auto form-border form-title-text">Vérification du compte mobile des rentes</legend>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Entrer le code envoyé par sms pour valider</label>
                                    <input class="form-control" type="text" placeholder="Code de validation du compte mobile" v-model="otpPhoneValidationCode">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-lg btn-block" @click="emailValidationLogic">
                            Je valide mon compte mobile
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import Vue from 'vue';
    import {registerSubscription, getSubscriberInfo, sendConfirmPhoneOtp, saveSubscription} from './subscribe.js';
    // Import component
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        props: ['id', 'pid'],
        data: function () {
            return {
                subscriberPartnerCheck: false,
                subscriberMoralePersonName: "",
                subscriberMoralePersonRepName: "",
                subscriberFirstName: "",
                subscriberLastName: "",
                subscriberBirthDate: "",
                subscriberBirthPlace: "",
                subscriberCniNumber: "",
                subscriberCniDate: "",
                subscriberCniPlace: "",
                subscriberPhone: "",
                subscriberPhone2: "",
                subscriberGender: "",
                subscriberEmail: "",
                subscriberProfession: "",
                subscriberTown: "",
                subscriberPartnerLastName: "",
                subscriberPartnerFirstName: "",
                subscriberPartnerPhone: "",
                subscriberPartnerEmail: "",
                subscriptionPartNumber: "",
                subscriberMobileAccountCheck: false,
                subscriberMobileAccountOperator: "Afrikpay",
                subscriberMobileAccountNumber: "",
                subscriberBankCheck: false,
                subscriptionCampaignAwareness: "Réseau sociaux",
                subscriberAgree: false,
                subscriptionBankName: "",
                subscriptionBankCode: "",
                subscriptionBankRib: "",
                subscriptionBankAgence: "",
                subscriptionBankAccountNumber: "",
                subscriptionBankKey: "",
                subscriptionBankIban: "",
                isLoading: false,
                fullPage: true,
                subscriberData: "",
                returnOtpCode: "",
                otpPhoneValidationCode: "",
                subscriberMoralePersonRepLastName: "",
                serverError: "",
                country: "",
                region: "",
                nationality: "",
                subscriberLanguage: ""
            }
        },
        components: {
            Loading
        },
        computed: {
            serverErrors(){
                return this.serverError;
            }
        },
        methods:{
            subscriberPartnerCheckLogic(){
                this.subscriberPartnerCheck = !this.subscriberPartnerCheck;
            },
            subscriberMobileAccountCheckLogic(){
                this.subscriberMobileAccountCheck = !this.subscriberMobileAccountCheck
            },
            subscriberBankCheckLogic(){
                this.subscriberBanktCheck = !this.subscriberBanktCheck;
            },
            subscriberAgreeLogic(){
                this.isLoading = true;
                saveSubscription(
                    this.subscriberPartnerFirstName,
                    this.subscriberPartnerLastName,
                    this.subscriberPartnerPhone,
                    this.subscriberPartnerEmail,
                    this.subscriptionPartNumber,
                    this.subscriberMobileAccountOperator,
                    this.subscriberMobileAccountNumber,
                    this.subscriptionBankName,
                    this.subscriptionBankCode,
                    this.subscriptionBankRib,
                    this.subscriptionBankAgence,
                    this.subscriptionBankAccountNumber,
                    this.subscriptionBankKey,
                    this.subscriptionBankIban,
                    this.subscriptionCampaignAwareness,
                    this.id,
                    this.pid
                ).then(error => {
                    this.serverError = error;
                });
                setTimeout(() => {
                    this.isLoading = false;
                    $('#subscriptionAgreementModalCenter').modal('hide');
                },10000)
            },
            onCancel() {
                console.log('User cancelled the loader.')
            },
            emailValidationLogic(){
                this.isLoading = true;
                setTimeout(() => {
                    this.isLoading = false;
                    if(parseInt(this.returnOtpCode) === parseInt(this.otpPhoneValidationCode)){
                        $('#mobileAccountModalCenter').modal('hide');
                        $('#subscriptionAgreementModalCenter').modal('show');
                    }else{
                        alert("Le code secret n'est pas valide, veuiller rééssayer.")
                    }
                },10000)
            },
            subscribeLogic(){
                this.isLoading = true;
                if(this.subscriberBankCheck === false){
                    sendConfirmPhoneOtp(this.subscriberMobileAccountNumber, this.subscriberMobileAccountNumber).then(data => {
                        this.returnOtpCode =  data.Otp;
                    }, (error) => {
                        console.log(error);
                    });
                }
                setTimeout(() => {
                    this.isLoading = false;
                    if(this.subscriberBankCheck === false){
                        $('#mobileAccountModalCenter').modal('show');
                    }else{
                        $('#subscriptionAgreementModalCenter').modal('show');
                    }
                },10000)
            },
            subscriberInfo(){
                //console.log(this.pid);
                getSubscriberInfo(this.id)
                .then((data) => {
                    this.subscriberData = data.subscriber;
                    //console.log(this.subscriberData);
                    this.subscriberFirstName = this.subscriberData.subscriberFirstname;
                    this.subscriberLastName = this.subscriberData.subscriberLastname;
                    this.subscriberBirthDate = this.subscriberData.subscriberBirthdate.timestamp;
                    this.subscriberBirthPlace = this.subscriberData.subscriberBirthPlace;
                    this.subscriberCniNumber = this.subscriberData.subscriberIdentityCardNumber;
                    this.subscriberCniPlace = this.subscriberData.subscriberIdentityCardDeliveryPlace;
                    this.subscriberPhone = this.subscriberData.subscriberTelephone;
                    this.subscriberPhone2 = this.subscriberData.subscriberOtherTelephone;
                    this.subscriberEmail = this.subscriberData.subscriberEmail;
                    this.subscriberProfession = this.subscriberData.subscriberProfession;
                    this.subscriberTown = this.subscriberData.subscriberTown;
                    this.subscriberMoralePersonName = this.subscriberData.subscriberEnterpriseName;
                    this.subscriberMoralePersonRepName = this.subscriberData.subscriberDirectorFirstname;
                    this.subscriberMoralePersonRepLastName = this.subscriberData.subscriberDirectorLastname;
                    this.subscriberMoralePersonRepName = this.subscriberData.subscriberDirectorFirstname;
                    this.subscriberMoralePersonRepLastName = this.subscriberData.subscriberDirectorLastname;
                    this.subscriberMoralePersonName = this.subscriberData.subscriberEnterpriseName;
                    this.country = this.subscriberData.subscriberCountry;
                    this.region = this.subscriberData.subscriberRegion;
                    this.nationality = this.subscriberData.subscriberNationality;
                    this.subscriberLanguage = this.subscriberData.subscriberLanguage;
                    this.subscriberGender = this.subscriberData.subscriberGender;
                })
                .catch((error)  => {
                    console.log(error);
                })
            }
        },
        created: function () {
            this.subscriberInfo();
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
    }

    .bankNumberBox{
        margin-top: -1rem;
    }

    .agreeBox{
        margin-right: 1rem;
    }
</style>