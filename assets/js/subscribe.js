/**
 * Created by Georges on 25/08/2020.
 */
/**
 * Created by Georges on 07/05/2020.
 */
import Axios from "axios";

const routes = require('../../public/js/fos_js_routes.json');
import Routing from "../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js";

Routing.setRoutingData(routes);

function registerSubscription(
){
    return Axios.get(`/subscription/summary/4`)
        .then((response) => {
            console.log("Go to subscriber summary");
            //console.log(response);
            //let userData = response.config.data;
            //let userId = response.data.userId;
            //console.log(userData);
            //console.log(userId);
            window.location.href = Routing.generate('subscriptionSummary', {
                id: 4,
            });
        }, (error) => {
            console.log(error);
        });
}

function getSubscriberInfo(
    userId
){
    return Axios.get('/get/subscriber', {
        params: {
            userId: userId
        }
    })
        .then((response) => {
            console.log(response.data);
            return response.data;
        }, (error) => {
            console.log(error);
        });
}

function sendConfirmPhoneOtp(
    subscriberIdentity,
    subscriberPhone,
){
    return Axios.post('/identification/phone/otp', {
        subscriberIdentity: subscriberIdentity,
        subscriberPhone: subscriberPhone
    })
        .then(response => {
            return  response.data;
        }, (error) => {
            console.log(error);
        });
}

function saveSubscription(
    subscriberPartnerFirstName,
    subscriberPartnerLastName,
    subscriberPartnerPhone,
    subscriberPartnerEmail,
    subscriptionPartNumber,
    subscriberMobileAccountOperator,
    subscriberMobileAccountNumber,
    subscriptionBankName,
    subscriptionBankCode,
    subscriptionBankRib,
    subscriptionBankAgence,
    subscriptionBankAccountNumber,
    subscriptionBankKey,
    subscriptionBankIban,
    subscriptionCampaignAwareness,
    subscriberId,
    projectId
){
    console.log("Saving subscription...");
    return Axios.post('/subscription/save', {
        subscriberPartnerFirstName: subscriberPartnerFirstName,
        subscriberPartnerLastName: subscriberPartnerLastName,
        subscriberPartnerPhone: subscriberPartnerPhone,
        subscriberPartnerEmail: subscriberPartnerEmail,
        subscriptionPartNumber: subscriptionPartNumber,
        subscriberMobileAccountOperator: subscriberMobileAccountOperator,
        subscriberMobileAccountNumber: subscriberMobileAccountNumber,
        subscriptionBankName: subscriptionBankName,
        subscriptionBankCode: subscriptionBankCode,
        subscriptionBankRib: subscriptionBankRib,
        subscriptionBankAgence: subscriptionBankAgence,
        subscriptionBankAccountNumber: subscriptionBankAccountNumber,
        subscriptionBankKey: subscriptionBankKey,
        subscriptionBankIban: subscriptionBankIban,
        subscriptionCampaignAwareness: subscriptionCampaignAwareness,
        subscriberId: subscriberId,
        projectId: projectId
    })
        .then(response => {
            console.log(response.data);
            window.location.href = Routing.generate('subscriptionSummary', {
                id: response.data.subscriptionId
            });
            //return  response.data;
        }, (error) => {
            console.log(error);
            return error
        });
}

function getSubscriptionInfo(
    subscriptionId
){
    return Axios.get('/get/subscription', {
        params: {
            subscriptionId: subscriptionId
        }
    })
        .then((response) => {
            //console.log(response.data);
            return response.data;
        }, (error) => {
            console.log(error);
        });
}


export {registerSubscription, getSubscriberInfo, sendConfirmPhoneOtp, saveSubscription};

