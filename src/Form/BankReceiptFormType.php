<?php
/**
 * Created by PhpStorm.
 * User: Georges
 * Date: 03/04/2020
 * Time: 16:09
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;


class BankReceiptFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', TextType::class, [
                'label' => "Montant du virement",
                'required' => True,
            ])
            ->add('bank_receipt', FileType::class, [
                'label' => 'Une copie du virement (jpg or png file)',

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

            ->add('pay', SubmitType::class, [
                'attr' => array('class' => 'btn-primary btn-lg btn-block'),
                'label' => "Je valide"
            ]);
    }
}