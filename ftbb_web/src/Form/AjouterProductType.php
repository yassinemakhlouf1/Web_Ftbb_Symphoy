<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjouterProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', ChoiceType::class, ['choices' => ['Vêtements'=>'Vêtements' ,
                'Equipements'=>'Equipements','Abonnements'=>'Abonnements',] ])
            ->add('stock')
            ->add('name')
            ->add('price')
            ->add('details')
            ->add('idAdmin')
            ->add('photo',FileType::class,[
                'required'=>false,'mapped'=>false,
            ])

            ->add('Ajouter' , SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
