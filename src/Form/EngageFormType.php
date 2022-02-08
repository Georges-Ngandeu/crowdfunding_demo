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


class EngageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('payment_method', ChoiceType::class, array(
                'choices' => array(
                    'Afrikpay' => 'Afrikpay',
                    'Orange Money'  => 'Orange Money',
                    'Mtn Mobile Money'  => 'Mtn Mobile Money',
                    'Express Union Mobile Money'  => 'Express Union Mobile Money'
                ),
                'label' => "Moyen de paiement"
            ))
            ->add('phone', TextType::class, [
                'label' => "Numéro Mobile Money"
            ])
            ->add('amount', TextType::class, [
                'label' => "Montant"
            ])

            ->add('pay', SubmitType::class, [
                'attr' => array('class' => 'btn-primary btn-lg btn-block'),
                'label' => "Je valide"
            ]);
    }

//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults([
//            'data_class'=>Author::class
//        ]);
//    }
}