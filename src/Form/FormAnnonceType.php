<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FormAnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('poste',null,  ["label"=>"Poste   ", "label_attr"=>["class"=>"fs-14 text-black fw-medium mb-0"], "attr"=>["class"=>"form-control form--control user-text-editor"]])
            ->add('entreprise',null,  ["label"=>"Nom de l'entreprise    ", "label_attr"=>["class"=>"fs-14 text-black fw-medium mb-0"], "attr"=>["class"=>"form-control form--control user-text-editor "]])



            ->add('description', null, ["label"=>"Description du poste ", "label_attr"=>["class"=>"fs-14 text-black fw-medium mb-0"], 
            "attr"=>["class"=>"form-control form--control user-text-editor", "rows"=>6 , "cols"=>10]])
            ->add('adresse',  null, ["label"=>"Adresse ", "label_attr"=>["class"=>"fs-14 text-black fw-medium mb-0"], "attr"=>["class"=>"form-control form--control user-text-editor "]])

        
            ->add('typeContrat',  ChoiceType::class, array('choices'=>array(
                "choisir type de contrat "=> null,
                "CDI"=> "CDI",
                "CIVP"=>"CIVP",
                "CDD"=>"CDD",
                "Karama"=>"Karama",
                "Stage"=>"Stage")))

            ->add('salaire',  null, ["label"=>"Salaire ", "label_attr"=>["class"=>"fs-14 text-black fw-medium mb-0"], "attr"=>["class"=>"form-control form--control user-text-editor "]])
            ->add("save",SubmitType::class,[ "attr"=>["class"=>"btn btn-primary rounded-pill py-2 px-4"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
