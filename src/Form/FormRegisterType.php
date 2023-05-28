<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType; 


class FormRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email',null,  ["label"=>"Adresse email   ", "label_attr"=>["class"=>"fs-14 text-black fw-medium mb-0"], "attr"=>["class"=>"form-control"]])
        ->add('password', PasswordType::class, ["label"=>"Mot de passe   ", "label_attr"=>["class"=>"fs-14 text-black fw-medium mb-0"], "attr"=>["class"=>"form-control"]])
        ->add('nom',null,  ["label"=>"Nom   ", "label_attr"=>["class"=>"fs-14 text-black fw-medium mb-0"], "attr"=>["class"=>"form-control"]])
        ->add('prenom',null,  ["label"=>"Prénom   ", "label_attr"=>["class"=>"fs-14 text-black fw-medium mb-0"], "attr"=>["class"=>"form-control"]])
        ->add('telephone',null,  ["label"=>"Numéro de téléphone  ", "label_attr"=>["class"=>"fs-14 text-black fw-medium mb-0"], "attr"=>["class"=>"form-control"]])
        ->add('type', ChoiceType::class, array('choices'=>array(
            "choisir son type "=> null,
            "Recruteur"=> "Recruteur",
            "Candidat"=>"Candidat")))
        
        ->add("save",SubmitType::class,["label"=>"Inscription", "attr"=>["class"=>"btn theme-btn"], "attr"=>["class"=>"btn btn-primary rounded-pill py-2 px-4"]
        ])
    ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
