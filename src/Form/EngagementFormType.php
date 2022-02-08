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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class EngagementFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subscription_partner_option', CheckboxType::class, [
                'label'    => 'Souhaitez vous associé un partenaire ?',
                'required' => false,
            ])
            ->add('subscription_partner_firstname', TextType::class, [
                'label' => "Nom du partenaire",
                'required' => false,
            ])

            ->add('subscription_partner_lastname', TextType::class, [
                'label' => "Prénom du partenaire",
                'required' => false,
            ])

            ->add('subscription_partner_phone', TextType::class, [
                'label' => "Telephone du partenaire",
                'required' => false,
            ])

            ->add('subscription_partner_email', TextType::class, [
                'label' => "Email du partenaire",
                'required' => false,
            ])

            ->add('subscription_number', IntegerType::class, [
                'label' => "Nombre de part*",
                'required' => false,
            ])

            ->add('subscription_mobile_account', TextType::class, [
                'label' => "Compte mobile pour recevoir vos rentes*",
                'required' => false,
            ])

            ->add('subscription_mobile_operator', ChoiceType::class, [
                'choices'  => array(
                    'Afrikpay' => 'Afrikpay',
                    'Express Union Mobile Money' => 'Express Union Mobile Money',
                    'Mtn Mobile Money' => 'Mtn Mobile Money',
                    'Orange Money' => 'Orange Money',
                    'Paypal' => 'Paypal'
                ),
                'required' => false,
                'label' => "Choix de l'opérateur*",
            ])

            ->add('subscription_campaign_awareness', ChoiceType::class, [
                'choices'  => array(
                    'Réseau sociaux' => 'Réseau sociaux',
                    'Recommendation' => 'Recommendation',
                    'Google' => 'Google',
                    'Conférence' => 'Conférence'
                ),
                'required' => false,
                'label' => "Ou avez vous entendu parler de la campagne* ?",
            ])

            ->add('subscribe', SubmitType::class, [
                'attr' => array('class' => 'btn-primary btn-lg btn-block'),
                'label' => "Je souscris à ce projet"
            ]);
    }

//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults([
//            'data_class'=>Author::class
//        ]);
//    }
}