<?php
/**
 * Created by PhpStorm.
 * User: Georges
 * Date: 29/06/2020
 * Time: 14:04
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Intl\Languages;
use Symfony\Component\Intl\Countries;


class CountryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        \Locale::setDefault('en');

        $countries = Countries::getNames();

        dump($countries); die;

        $builder
            ->add('country', ChoiceType::class, array(
                'choices' => $countries
//                'choices' => [
//                      "Afghanistan" => "Afghanistan",
//                      "Afrique du Sud" => "Afrique du Sud",
//                      "Albanie" => "Albanie",
//                      "Algérie" => "Algérie",
//                      "Allemagne" => "Allemagne",
//                      "Andorre" => "Andorre",
//                      "Angola" => "Angola",
//                      "Anguilla" => "Anguilla",
//                      "Antarctique" => "Antarctique",
//                      "Antigua-et-Barbuda" => "Antigua-et-Barbuda",
//                      "Arabie saoudite" => "Arabie saoudite",
//                      "Argentine" => "Argentine",
//                      "Arménie" => "Arménie",
//                      "Aruba" => "Aruba",
//                      "Australie" => "Australie",
//                      "Autriche" => "Autriche",
//                      "Azerbaïdjan" => "Azerbaïdjan",
//                      "Bahamas" => "Bahamas",
//                      "Bahreïn" => "Bahreïn",
//                      "Bangladesh" => "Bangladesh",
//                      "Barbade" => "Barbade",
//                      "Belgique" => "Belgique",
//                      "Belize" => "Belize",
//                      "Bénin" => "Bénin",
//                      "Bermudes" => "Bermudes",
//                      "Bhoutan" => "Bhoutan",
//                      "Biélorussie" => "Biélorussie",
//                      "Bolivie" => "Bolivie",
//                      "Bosnie-Herzégovine" => "Bosnie-Herzégovine",
//                      "Botswana" => "Botswana",
//                      "Brésil" => "Brésil",
//                      "Brunéi Darussalam" => "Brunéi Darussalam",
//                      "Bulgarie" => "Bulgarie",
//                      "Burkina Faso" => "Burkina Faso",
//                      "Burundi" => "Burundi",
//                      "Cambodge" => "Cambodge",
//                      "Cameroun" => "Cameroun",
//                      "Canada" => "Canada",
//                      "Cap-Vert" => "Cap-Vert",
//                      "Chili" => "Chili",
//                      "Chine" => "Chine",
//                      "Chypre" => "Chypre",
//                      "Colombie" => "Colombie",
//                      "Comores" => "Comores",
//                      "Congo-Brazzaville" => "Congo-Brazzaville",
//                      "Congo-Kinshasa" => "Congo-Kinshasa",
//                      "Corée du Nord" => "Corée du Nord",
//                      "Corée du Sud" => "Corée du Sud",
//                      "CR" => "Costa Rica",
//                      "CI" => "Côte d’Ivoire"
//                      "HR" => "Croatie"
//                      "CU" => "Cuba"
//                      "CW" => "Curaçao"
//                      "DK" => "Danemark"
//                      "DJ" => "Djibouti"
//                      "DM" => "Dominique"
//                      "EG" => "Égypte"
//                      "AE" => "Émirats arabes unis"
//                      "EC" => "Équateur"
//                      "ER" => "Érythrée"
//                      "ES" => "Espagne"
//                      "EE" => "Estonie"
//                      "SZ" => "Eswatini"
//                      "VA" => "État de la Cité du Vatican"
//                      "FM" => "États fédérés de Micronésie"
//                      "US" => "États-Unis"
//                      "ET" => "Éthiopie"
//                      "FJ" => "Fidji"
//                      "FI" => "Finlande"
//                      "FR" => "France"
//                      "GA" => "Gabon"
//                      "GM" => "Gambie"
//                      "GE" => "Géorgie"
//                      "GS" => "Géorgie du Sud et îles Sandwich du Sud"
//                      "GH" => "Ghana"
//                      "GI" => "Gibraltar"
//                      "GR" => "Grèce"
//                      "GD" => "Grenade"
//                      "GL" => "Groenland"
//                      "GP" => "Guadeloupe"
//                      "GU" => "Guam"
//                      "GT" => "Guatemala"
//                      "GG" => "Guernesey"
//                      "GN" => "Guinée"
//                      "GQ" => "Guinée équatoriale"
//                      "GW" => "Guinée-Bissau"
//                      "GY" => "Guyana"
//                      "GF" => "Guyane française"
//                      "HT" => "Haïti"
//                      "HN" => "Honduras"
//                      "HU" => "Hongrie"
//                      "BV" => "Île Bouvet"
//                      "CX" => "Île Christmas"
//                      "IM" => "Île de Man"
//                      "NF" => "Île Norfolk"
//                      "AX" => "Îles Åland"
//                      "KY" => "Îles Caïmans"
//                      "CC" => "Îles Cocos"
//                      "CK" => "Îles Cook"
//                      "FO" => "Îles Féroé"
//                      "HM" => "Îles Heard et McDonald"
//                      "FK" => "Îles Malouines"
//                      "MP" => "Îles Mariannes du Nord"
//                      "MH" => "Îles Marshall"
//                      "UM" => "Îles mineures éloignées des États-Unis"
//                      "PN" => "Îles Pitcairn"
//                      "SB" => "Îles Salomon"
//                      "TC" => "Îles Turques-et-Caïques"
//                      "VG" => "Îles Vierges britanniques"
//                      "VI" => "Îles Vierges des États-Unis"
//                      "IN" => "Inde"
//                      "ID" => "Indonésie"
//                      "IQ" => "Irak"
//                      "IR" => "Iran"
//                      "IE" => "Irlande"
//                      "IS" => "Islande"
//                      "IL" => "Israël"
//                      "IT" => "Italie"
//                      "JM" => "Jamaïque"
//                      "JP" => "Japon"
//                      "JE" => "Jersey"
//                      "JO" => "Jordanie"
//                      "KZ" => "Kazakhstan"
//                      "KE" => "Kenya"
//                      "KG" => "Kirghizistan"
//                      "KI" => "Kiribati"
//                      "KW" => "Koweït"
//                      "RE" => "La Réunion"
//                      "LA" => "Laos"
//                      "LS" => "Lesotho"
//                      "LV" => "Lettonie"
//                      "LB" => "Liban"
//                      "LR" => "Libéria"
//                      "LY" => "Libye"
//                      "LI" => "Liechtenstein"
//                      "LT" => "Lituanie"
//                      "LU" => "Luxembourg"
//                      "MK" => "Macédoine du Nord"
//                      "MG" => "Madagascar"
//                      "MY" => "Malaisie"
//                      "MW" => "Malawi"
//                      "MV" => "Maldives"
//                      "ML" => "Mali"
//                      "MT" => "Malte"
//                      "MA" => "Maroc"
//                      "MQ" => "Martinique"
//                      "MU" => "Maurice"
//                      "MR" => "Mauritanie"
//                      "YT" => "Mayotte"
//                      "MX" => "Mexique"
//                      "MD" => "Moldavie"
//                      "MC" => "Monaco"
//                      "MN" => "Mongolie"
//                      "ME" => "Monténégro"
//                      "MS" => "Montserrat"
//                      "MZ" => "Mozambique"
//                      "MM" => "Myanmar (Birmanie)"
//                      "NA" => "Namibie"
//                      "NR" => "Nauru"
//                      "NP" => "Népal"
//                      "NI" => "Nicaragua"
//                      "NE" => "Niger"
//                      "NG" => "Nigéria"
//                      "NU" => "Niue"
//                      "NO" => "Norvège"
//                      "NC" => "Nouvelle-Calédonie"
//                      "NZ" => "Nouvelle-Zélande"
//                      "OM" => "Oman"
//                      "UG" => "Ouganda"
//                      "UZ" => "Ouzbékistan"
//                      "PK" => "Pakistan"
//                      "PW" => "Palaos"
//                      "PA" => "Panama"
//                      "PG" => "Papouasie-Nouvelle-Guinée"
//                      "PY" => "Paraguay"
//                      "NL" => "Pays-Bas"
//                      "BQ" => "Pays-Bas caribéens"
//                      "PE" => "Pérou"
//                      "PH" => "Philippines"
//                      "PL" => "Pologne"
//                      "PF" => "Polynésie française"
//                      "PR" => "Porto Rico"
//                      "PT" => "Portugal"
//                      "QA" => "Qatar"
//                      "HK" => "R.A.S. chinoise de Hong Kong"
//                      "MO" => "R.A.S. chinoise de Macao"
//                      "CF" => "République centrafricaine"
//                      "DO" => "République dominicaine"
//                      "RO" => "Roumanie"
//                      "GB" => "Royaume-Uni"
//                      "RU" => "Russie"
//                      "RW" => "Rwanda"
//                      "EH" => "Sahara occidental"
//                      "BL" => "Saint-Barthélemy"
//                      "KN" => "Saint-Christophe-et-Niévès"
//                      "SM" => "Saint-Marin"
//                      "MF" => "Saint-Martin"
//                      "SX" => "Saint-Martin (partie néerlandaise)"
//                      "PM" => "Saint-Pierre-et-Miquelon"
//                      "VC" => "Saint-Vincent-et-les-Grenadines"
//                      "SH" => "Sainte-Hélène"
//                      "LC" => "Sainte-Lucie"
//                      "SV" => "Salvador"
//                      "WS" => "Samoa"
//                      "AS" => "Samoa américaines"
//                      "ST" => "Sao Tomé-et-Principe"
//                      "SN" => "Sénégal"
//                      "RS" => "Serbie"
//                      "SC" => "Seychelles"
//                      "SL" => "Sierra Leone"
//                      "SG" => "Singapour"
//                      "SK" => "Slovaquie"
//                      "SI" => "Slovénie"
//                      "SO" => "Somalie"
//                      "SD" => "Soudan"
//                      "SS" => "Soudan du Sud"
//                      "LK" => "Sri Lanka"
//                      "SE" => "Suède"
//                      "CH" => "Suisse"
//                      "SR" => "Suriname"
//                      "SJ" => "Svalbard et Jan Mayen"
//                      "SY" => "Syrie"
//                      "TJ" => "Tadjikistan"
//                      "TW" => "Taïwan"
//                      "TZ" => "Tanzanie"
//                      "TD" => "Tchad"
//                      "CZ" => "Tchéquie"
//                      "TF" => "Terres australes françaises"
//                      "IO" => "Territoire britannique de l’océan Indien"
//                      "PS" => "Territoires palestiniens"
//                      "TH" => "Thaïlande"
//                      "TL" => "Timor oriental"
//                      "TG" => "Togo"
//                      "TK" => "Tokelau"
//                      "TO" => "Tonga"
//                      "TT" => "Trinité-et-Tobago"
//                      "TN" => "Tunisie"
//                      "TM" => "Turkménistan"
//                      "TR" => "Turquie"
//                      "TV" => "Tuvalu"
//                      "UA" => "Ukraine"
//                      "UY" => "Uruguay"
//                      "VU" => "Vanuatu"
//                      "VE" => "Venezuela"
//                      "VN" => "Vietnam"
//                      "WF" => "Wallis-et-Futuna"
//                      "YE" => "Yémen"
//                      "ZM" => "Zambie"
//                      "ZW" => "Zimbabwe"
//                ],
            ))
        ;
    }
}