<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FormContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message', null, ["label"=>"Message ", "label_attr"=>["class"=>"fs-14 text-black fw-medium mb-0"], 
            "attr"=>["class"=>"form-control form--control user-text-editor", "rows"=>6 , "cols"=>10]])
            ->add("save",SubmitType::class,["label"=>"Envoyer", "attr"=>["class"=>"btn theme-btn"], "attr"=>["class"=>"btn btn-primary rounded-pill py-2 px-4"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
