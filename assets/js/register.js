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

function registerUser(
    moralePersonName,
    moralePersonRepresentant,
    subscriberFirstName,
    subscriberLastName,
    subscriberBirthDate,
    subscriberBirthPlace,
    subscriberCniNumber,
    subscriberCniDate,
    subscriberCniPlace,
    subscriberPhone,
    subscriberEmail,
    subscriberProfession,
    subscriberTown,
    subscriberMaritalStatus,
    subscriberProfessionalStatus,
    subscriberRevenuEstimate,
    subscriberRevenuOrigin,
    id
){
    return Axios.post(`/register/user/${id}`, {
        moralePersonName: moralePersonName,
        moralePersonRepresentant: moralePersonRepresentant,
        subscriberFirstName: subscriberFirstName,
        subscriberLastName: subscriberLastName,
        subscriberBirthDate: subscriberBirthDate,
        subscriberBirthPlace: subscriberBirthPlace,
        subscriberCniNumber: subscriberCniNumber,
        subscriberCniDate: subscriberCniDate,
        subscriberCniPlace: subscriberCniPlace,
        subscriberPhone: subscriberPhone,
        subscriberEmail: subscriberEmail,
        subscriberProfession: subscriberProfession,
        subscriberTown: subscriberTown,
        subscriberMaritalStatus: subscriberMaritalStatus,
        subscriberProfessionalStatus: subscriberProfessionalStatus,
        subscriberRevenuEstimate: subscriberRevenuEstimate,
        subscriberRevenuOrigin: subscriberRevenuOrigin
    })
        .then((response) => {
            //console.log(response);
            //let userData = response.config.data;
            //let userId = response.data.userId;
            //console.log(userData);
            //console.log(userId);
            window.location.href = Routing.generate('detail', {
                id: id,
            });
        }, (error) => {
            console.log(error);
        });
}

function saveSubscriberInfo(
    moralePersonName,
    moralePersonRepresentant,
    subscriberFirstName,
    subscriberLastName,
    subscriberBirthDate,
    subscriberBirthPlace,
    subscriberCniNumber,
    subscriberCniDate,
    subscriberCniPlace,
    subscriberPhone,
    subscriberPhone2,
    subscriberEmail,
    subscriberProfession,
    subscriberTown,
    subscriberMaritalStatus,
    subscriberProfessionalStatus,
    subscriberRevenuEstimate,
    subscriberRevenuOrigin,
    subscriberOtherRevenuOrigin,
    formData,
    id,
    subscriberNationality,
    subscriberGender,
    moralePersonRepresentantLastname,
    country,
    region,
    subscriberLanguage
){
    return Axios.post('/ajax/register/user', {
        moralePersonName: moralePersonName,
        moralePersonRepresentant: moralePersonRepresentant,
        subscriberFirstName: subscriberFirstName,
        subscriberLastName: subscriberLastName,
        subscriberBirthDate: subscriberBirthDate,
        subscriberBirthPlace: subscriberBirthPlace,
        subscriberCniNumber: subscriberCniNumber,
        subscriberCniDate: subscriberCniDate,
        subscriberCniPlace: subscriberCniPlace,
        subscriberPhone: subscriberPhone,
        subscriberPhone2: subscriberPhone2,
        subscriberEmail: subscriberEmail,
        subscriberProfession: subscriberProfession,
        subscriberTown: subscriberTown,
        subscriberMaritalStatus: subscriberMaritalStatus,
        subscriberProfessionalStatus: subscriberProfessionalStatus,
        subscriberRevenuEstimate: subscriberRevenuEstimate,
        subscriberRevenuOrigin: subscriberRevenuOrigin,
        subscriberOtherRevenuOrigin: subscriberOtherRevenuOrigin,
        subscriberNationality: subscriberNationality,
        subscriberGender: subscriberGender,
        moralePersonRepresentantLastname: moralePersonRepresentantLastname,
        country: country,
        region: region,
        subscriberLanguage: subscriberLanguage
    })
        .then((response) => {
            let userId = response.data.userId;
            console.log(userId);
            return Axios.post( `/ajax/user/photo/${userId}`,
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((response) => {
                window.location.href = Routing.generate('detail', {
                    id: id,
                    userId: userId
                });
            }).catch((error) => {
                console.log(error);
                return error
            });
        }, (error) => {
            console.log(error);
            return error;
        });
}

function sendConfirmOtp(
    subscriberIdentity,
    subscriberEmail,
){
    return Axios.post('/identification/email/otp/send/', {
        subscriberIdentity: subscriberIdentity,
        subscriberEmail: subscriberEmail
    })
        .then(response => {
            return  response.data;
        }, (error) => {
            console.log(error);
        });
}

function validateOtp(
    subscriberOtp,
    subscriberPhone
){
    return Axios.post('/identification/otp/validate', {
        subscriberOtp: subscriberOtp
    })
        .then((response) => {
            console.log(response.data);
        }, (error) => {
            console.log(error);
        });
}

function checkEmail(
    userEmail,
    projectId
){
    return Axios.post('/identification/check/email', {
        userEmail: userEmail,
        projectId: projectId
    })
        .then((response) => {
            console.log(response.data);
            if(response.data.Result === true){
                window.location.href = Routing.generate('detail', {
                    id: projectId,
                });
            }else{
                alert("Utilisateur introuvable dans le système!");
                //return response.data.Result;
            }
        }, (error) => {
            console.log(error);
            return error;
        });
}

function goToRegisterUser(
    projectId
){
    window.location.href = Routing.generate('registerUser', {
        id: projectId,
    });
}

export {
        registerUser,
        saveSubscriberInfo,
        sendConfirmOtp,
        validateOtp,
        checkEmail,
        goToRegisterUser
    };

