<?php
/**
 * Created by PhpStorm.
 * User: Georges
 * Date: 03/04/2020
 * Time: 16:09
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use App\Entity\Author;
use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateIntervalToArrayTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Intl\Countries;



class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        \Locale::setDefault('en');

        $countries = Countries::getNames();

        $builder
            ->add('civility', ChoiceType::class, array(
                'choices'  => array(
                    'Monsieur' => 'Monsieur',
                    'Madame' => 'Madame',
                    'Mademoiselle' => 'Mademoiselle'
                ),
                'expanded' => false,
                'multiple' => false,
                'required' => false,
                'label' => "Civilité*",
            ))
            ->add('firstname', TextType::class, [
                'label' => "Nom*",
                'constraints' => new NotBlank()
            ])
            ->add('lastname', TextType::class, [
                'label' => "Prénom*",
                'constraints' => new NotBlank()
            ])
            ->add('enterprise', TextType::class, [
                'label' => "Nom personne morale",
                'required' => false
            ])
            ->add('director_firstname', TextType::class, [
                'label' => "Nom representant personne morale",
                'required' => false
            ])
            ->add('director_lastname', TextType::class, [
                'label' => "Prénom representant personne morale",
                'required' => false
            ])
            ->add('birthdate', DateType::class, [
                'label' => "Date de naissance*",
                'widget'=>'single_text'
            ])
            ->add('birth_place', TextType::class, [
                'label' => "Lieu de naissance*",
                'constraints' => new NotBlank()
            ])
            ->add('identity_card_number', TextType::class, [
                'label' => "Numéro CNI*",
                'constraints' => new NotBlank()
            ])
            ->add('identitycard_deliver_date', DateType::class, [
                'label' => "CNI Délivré le*",
                'widget'=>'single_text'
            ])
            ->add('identitycard_deliver_place', TextType::class, [
                'label' => "CNI délivré à*",
                'constraints' => new NotBlank()
            ])
            ->add('telephone', TextType::class, [
                'label' => "Numéro de téléphone*",
                'constraints' => new NotBlank()
            ])
            ->add('email', EmailType::class, [
                'label' => "Email*",
                'constraints' => new Email()
            ])
            ->add('profession', TextType::class, [
                'label' => "Profession*",
                'constraints' => new NotBlank()
            ])
            ->add('town', TextType::class, [
                'label' => "Ville de résidence*",
                'constraints' => new NotBlank()
            ])
            ->add('marital_status', ChoiceType::class, [
                'choices'  => array(
                    'Celibataire' => 'Celibataire',
                    'Marié' => 'Marié',
                    'Divorcé' => 'Divorcé'
                ),
                'required' => false,
                'label' => "Situation matrimoniale*",
            ])
            ->add('professional_status', ChoiceType::class, [
                'choices'  => array(
                    'Actif' => 'Actif',
                    'A la retraire' => 'A la retraire',
                ),
                'required' => false,
                'label' => "Situation professionnelle*",
            ])
            ->add('revenu', ChoiceType::class, [
                'choices'  => array(
                    '250000' => '250000',
                    '350000' => '350000',
                    '500000' => '500000'
                ),
                'required' => false,
                'label' => "Revenu estimatif*",
            ])
            ->add('revenu_origine', ChoiceType::class, [
                'choices'  => array(
                    'Affaires' => 'Affaires',
                ),
                'required' => false,
                'label' => "Origine des fonds*",
            ])
            ->add('subscriber_image', FileType::class, [
                'label' => "Pièce d'identité scannée, CNI (jpg or png file)*",

                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpeg2000',
                            'image/jpeg2000-image',
                            'image/pjpeg',
                            'image/svg',
                        ],
                        'mimeTypesMessage' => 'Uploader une image valide',
                    ])
                ],
            ])
            ->add('language', ChoiceType::class, array(
                'choices'  => array(
                    'Francais' => 'Francais',
                    'Anglais' => 'Anglais'
                ),
                'required' => false,
                'label' => "Langue*",
            ))
            ->add('username', TextType::class, [
                'label' => "Nom utilisateur*",
                'constraints' => new NotBlank()
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe*'],
                'second_options' => ['label' => 'Confirmer le mot de passe*'],
            ])
            ->add('save', SubmitType::class, [
                'attr' => array('class' => 'btn-primary btn-lg btn-block'),
                'label' => "Je crée mon compte"
            ]);
    }

//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults([
//            'validation_groups' => false,
//        ]);
//    }
}