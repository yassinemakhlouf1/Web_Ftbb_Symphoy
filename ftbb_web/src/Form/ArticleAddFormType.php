<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ArticleAddFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('text', TextareaType::class)
            ->add('author')
            ->add('url', FileType::class, [
                'mapped' => false
            ])
            ->add('category', ChoiceType::class, [
                'choices' => [
                    Article::$BREAKING_NEWS => 0,
                    Article::$HOT => 1,
                    Article::$ANNOUNCE => 2,
                    Article::$MISC => 3,
                ],

            ])
            ->add('publish', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
