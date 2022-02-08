<?php
/**
 * Created by PhpStorm.
 * User: Georges
 * Date: 03/04/2020
 * Time: 16:09
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use App\Entity\Manager;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class ManagerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('first_name', TextType::class, [
            'label' => "Nom"
        ])
            ->add('last_name', TextType::class, [
                'label' => "Prenom"
            ])
            ->add('user_name', TextType::class, [
                'label' => "Num utilisateur"
            ])
            ->add('email', EmailType::class, [
                'label' => "Email"
            ])
            ->add('phone', TextType::class, [
                'label' => "Numéro de téléphone"
            ])
            ->add('region', TextType::class, [
                'label' => "Région"
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
            ])
            ->add('save', SubmitType::class, [
                'attr' => array('class' => 'btn-primary btn-lg btn-block')
            ]);
    }

//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults([
//            'data_class'=>Manager::class
//        ]);
//    }
}