<?php
/**
 * Created by PhpStorm.
 * User: Georges
 * Date: 01/04/2020
 * Time: 10:24
 */

namespace App\Form;

use App\Entity\Project;
use App\Services\ManagerService;
use Doctrine\ORM\EntityRepository;
use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EditProjectFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('project_shortdescription', TextareaType::class, [
                'label' => "Description courte"
            ])
            ->add('project_cost', TextType::class, [
                'label' => "Cout du projet"
            ])
            ->add('project_numberaction', IntegerType::class, [
                'label' => "Nombre de souscription"
            ])
            ->add('project_minnumberaction', IntegerType::class, [
                'label' => "Nombre minimum de souscription"
            ])
            ->add('project_startdate', DateTimeType::class, [
                'label' => "Debut de la campagne",

            ])
            ->add('project_enddate', DateTimeType::class, [
                'label' => "Fin de la campagne",

            ])

            ->add( 'project_longdescription', FroalaEditorType::class,[
                'label' => "Description longue du projet",
                "language" => "fr",
                "toolbarInline" => false,
                "tableColors" => [ "#FFFFFF", "#FF0000" ],
                "saveParams" => [ "id" => "myEditorField" ]
            ])

            ->add('project_videourl', UrlType::class, [
                'label' => "Url de la video de la campagne"
            ])
            ->add('save', SubmitType::class, [
                'attr' => array('class' => 'btn-primary btn-lg btn-block')
            ]);
    }

//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults([
//            'data_class'=>Project::class
//        ]);
//    }

}