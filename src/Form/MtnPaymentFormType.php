<?php
/**
 * Created by PhpStorm.
 * User: Georges
 * Date: 22/08/2020
 * Time: 10:55
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;


class MtnPaymentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phone_number', TextType::class, [
                'label' => "Numéro de téléphone*",
                'constraints' => new NotBlank()
            ])
            ->add('amount', TextType::class, [
                'label' => "Montant*",
                'constraints' => new NotBlank()
            ])
            ->add('form_type', HiddenType::class, [
                'data' => 'mtn',
            ])
            ->add('Je paye', SubmitType::class, [
                'attr' => array('class' => 'btn-primary btn-lg btn-block')
            ]);
    }
}