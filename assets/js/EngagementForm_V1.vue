<template>
    <div class="card">
        <h5 class="card-header">Remplir ce formulaire pour souscrire au projet</h5>
        <div class="card-body">
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
                        <input class="form-control" type="text" placeholder="Representant personne morale" v-model="moralePersonRepresentant">
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
                        <input class="form-control" type="text" placeholder="Date de naissance" v-model="subscriberBirthDate">
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
                <legend  class="w-auto form-border form-title-text">Addresses du souscripteur</legend>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Téléphone</label>
                        <input class="form-control" type="text" placeholder="Téléphone" v-model="subscriberPhone">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input class="form-control" type="text" placeholder="Email" v-model="subscriberEmail">
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
                <div class="form-row">
                    <input class="form-control checkbox-custom" type="checkbox"  v-model="subscriberMobileAccountCheck" @click="subscriberMobileAccountCheckLogic">
                    <label class="form-check-label checkbox-text">Souhaitez vous associer un compte mobile ?</label>
                </div>
                <div class="form-row" v-if="subscriberMobileAccountCheck">
                    <div class="form-group col-md-6">
                        <label>Opérateur</label>
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
                <div class="form-row bankNumberBox">
                    <input class="form-control checkbox-custom" type="checkbox"  v-model="subscriberBankCheck" @click="subscriberBankCheckLogic">
                    <label class="form-check-label checkbox-text">Souhaitez vous associer un compte bancaire ?</label>
                </div>
                <div class="form-row" v-if="subscriberBankCheck">
                    <div class="form-group col-md-12">
                        <label>Numéro de compte bancaire</label>
                        <input class="form-control" type="text" placeholder="Nombre de part" v-model="subscriptionBankNumber">
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
                    <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#exampleModalCenter">
                        Je souscris à ce projet
                    </button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

                        Linked Websites
                        UBA Plc or any other UBA Group member is not responsible for the contents available on or the set-up of any other websites linked to this site. Access to and use of such other websites is at the user’s own risk and subject to any terms and conditions applicable to such access/use. By providing hyperlinks to other websites, UBA shall not be deemed to endorse, recommend, approve, guarantee or introduce any third parties or the service/products they provide on their web site, or have any form of cooperation with such third parties and web sites. The bank is not a party to any contractual arrangements entered into between you and the provider of the external website unless otherwise expressly specified or agreed to by the Bank.

                        Email
                        Email messages sent to the bank over the Internet cannot be guaranteed to be completely secure. The bank is not responsible for any damages incurred by users if they send a message to the bank, or if the bank sends a message to them at their request, over the Internet. The bank is not responsible in any way for direct, indirect, special or consequential damages arising out of the use of this website.

                        Transmitting over the Internet
                        Due to the nature of the Internet, transactions may be subject to interruption, transmission blackout, delayed transmission and incorrect data transmission. The Bank is not liable for malfunctions in communications facilities not under its control that may affect the accuracy or timeliness of messages and transactions you send.

                        Downloading
                        Please note that any software downloaded from this website is at your own risk and the bank neither assumes nor accepts liability for any loss, damage (whether direct or indirect) howsoever caused, as a result of any computer viruses, ‘Trojan Horses’, ‘Worms’, software ‘bombs’ or similar items or processes.

                        UBA Hyperlink Policy
                        Hyperlinks from UBA Plc to Websites outside the UBA Group
                        There may be cases on our website when the UBA provides hyperlinks to other locations or websites on the Internet. These hyperlinks lead to websites published or operated by third parties who are not affiliated with or in any way related to UBA. They have been included in our website to enhance your user experience and are presented for information purposes only. We endeavor to select reputable websites and sources of information for your convenience.

                        However, by providing hyperlinks to an external website or webpage, UBA shall not be deemed to endorse, recommend, approve, guarantee or introduce any third parties or the services/ products they provide on their websites, or to have any form of cooperation with such third parties and websites unless otherwise stated by UBA Plc.

                        We are not in any way responsible for the content of any externally linked website or webpage. You use or follow these links at your own risk and UBA is not responsible for any damages or losses incurred or suffered by you arising out of or in connection with your use of the link. UBA is not a party to any contractual arrangements entered into between you and the provider of the external website unless otherwise expressly specified or agreed to by UBA Plc.

                        Any links to websites that contain downloadable software are provided for your convenience only. Again we are not responsible for any difficulties you may encounter in downloading the software or for any consequences from your doing so. Please remember that the use of any software downloaded from the Internet may be governed by a licence agreement and your failure to observe the terms of such licence agreement may result in an infringement of intellectual property rights of the relevant software provider which we are not in any way responsible.

                        Our Trademarks and Copyright
                        The content and information contained within our website or delivered to you in connection with your use of our website is the property of UBA Plc. The materials on this website are protected by copyright and no part of such materials may be modified, reproduced, stored in a retrieval system, transmitted (in any form or by any means), copied, distributed, used for creating derivative works or used in any other way for commercial or public purposes without the Bank’s prior written consent.
                    </div>
                    <div class="modal-footer">
                        <div class="form-row bankNumberBox agreeBox">
                            <input class="form-control checkbox-custom" type="checkbox"  v-model="subscriberAgree" @click="subscriberAgreeLogic">
                            <label class="form-check-label checkbox-text">Je souscris à ce projet</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="secondExampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><h4>OTP Trigger</h4></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        OTP Confirmation Trigger
                    </div>
                    <div class="modal-footer">
                        OTP Action button
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import Vue from 'vue';

    export default {
        data: function () {
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
                subscriberEmail: "",
                subscriberProfession: "",
                subscriberTown: "",
                subscriberPartnerCheck: false,
                subscriberPartnerLastName: "",
                subscriberPartnerFirstName: "",
                subscriberPartnerPhone: "",
                subscriberPartnerEmail: "",
                subscriptionPartNumber: "",
                subscriberMobileAccountCheck: false,
                subscriberMobileAccountOperator: "",
                subscriberMobileAccountNumber: "",
                subscriberBankCheck: false,
                subscriptionBankNumber: "",
                subscriptionCampaignAwareness: "",
                subscriberAgree: false
            }
        },
        computed: {
        },
        methods:{
            moralePersonCheckLogic(){
                this.moralePersonCheck = !this.moralePersonCheck;
            },
            subscriberPartnerCheckLogic(){
                this.subscriberPartnerCheck = !this.subscriberPartnerCheck;
            },
            subscriberMobileAccountCheckLogic(){
                this.subscriberMobileAccountCheck = !this.subscriberMobileAccountCheck;
            },
            subscriberBankCheckLogic(){
                this.subscriberBanktCheck = !this.subscriberBanktCheck;
            },
            subscriberAgreeLogic(){
                this.subscriberBanktCheck = !this.subscriberBanktCheck;
                $('#exampleModalCenter').modal('hide');
                $('#secondExampleModalCenter').modal('show');
            },
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