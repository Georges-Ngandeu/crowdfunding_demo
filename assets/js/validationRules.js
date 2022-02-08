/**
 * Created by Georges on 26/08/2020.
 */

function required(name) {
    return {
        validator: (value) => value != "" && value !== undefined && value !== null,
        message: `Une valeur est requise pour le ${name}`
    }
}

function minLength(name, minlength) {
    return {
        validator: (value) => String(value).length >= minlength,
        message: `Au moins ${minlength} chiffres pour le ${name}`
    }
}

function exactLength(name, exactlength) {
    return {
        validator: (value) => String(value).length === exactlength,
        message: ` Exactement ${exactlength} caractères sont requis pour le ${name}`
    }
}

function alpha(name) {
    return {
        validator: (value) => /^[a-zA-Z]*$/.test(value),
        message: `${name} peut uniquement contenir des lettres`
    }
}

function internationalPhone(name) {
    return {
        validator: (value) => (/^\d{7,}$/).test(value.replace(/[\s()+\-\.]|ext/gi, '')),
        message: `${name} doit etre au format international`
    }
}

function numeric(name) {
    return {
        validator: (value) => /^[0-9]*$/.test(value),
        message: `Le ${name} ne peut contenir que des chiffres`
    }
}

function range(name, min, max) {
    return {
        validator: (value) => value >= min && value <= max,
        message: `${name} doit etre entre ${min} et ${max}`
    }
}

export default {
    phone: [required("Téléphone"), internationalPhone("Téléphone")],
    firstName: [required("Nom du souscripteur")],
    lastName: [required("Prénom du souscripteur")],
    Email: [required("Email du souscripteur")],
    birthPlace: [required("Lieu de naissance")],
    cniNumber: [required("Numéro de Cni")],
    cniPlace: [required("Cni délivré le")],
    profession: [required("Profession")],
    town: [required("Ville")],
}
