<?php

namespace App\Form;
use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Created by PhpStorm.
 * User: Georges
 * Date: 30/03/2020
 * Time: 14:52
 */
class SimpleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('form_field1', TextType::class, [
                'label' => "Form 1"
            ])
            ->add('form_field2', TextType::class, [
                'label' => "Form 2"
            ])
            ->add('form_field3', TextType::class, [
                'label' => "Form 3"
            ])
            ->add('form_field4', TextType::class, [
                'label' => "Form 4"
            ])
            ->add( 'froala_editor', FroalaEditorType::class,[
                "language" => "fr",
                "toolbarInline" => false,
                "tableColors" => [ "#FFFFFF", "#FF0000" ],
                "saveParams" => [ "id" => "myEditorField" ]
            ])
            ->add('save', SubmitType::class, [
                'attr' => array('class' => 'btn-primary btn-lg btn-block')
            ]);
    }

}