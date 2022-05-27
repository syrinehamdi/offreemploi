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
            ->add('poste')
            ->add('entreprise')
            ->add('description')
            ->add('adresse')

        
            ->add('typeContrat', ChoiceType::class, array('choices'=>array(
                "choisir type de contrat "=> null,
                "CDI"=> "CDI",
                "CIVP"=>"CIVP",
                "CDD"=>"CDD",
                "Karama"=>"Karama",
                "Stage"=>"Stage")))

            ->add('salaire')
            ->add("save",SubmitType::class,[ "attr"=>["class"=>"btn theme-btn"]
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
