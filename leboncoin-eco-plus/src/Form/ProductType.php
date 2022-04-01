<?php

namespace App\Form;

use App\DTO\ProductDto;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control']
                ])
            ->add('price', NumberType::class, [
                'attr' => ['class' => 'form-control']
                ])
            ->add('images', FileType::class, [
                'data_class' => null,
                'multiple' => true,
                'label' => false,
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'form-control textarea']
                ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'form-control']
            ])
            ->add('quality', ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'choices'  => [
                    'État neuf' => 1,
                    'Très bon état' => 2,
                    'Bon état' => 3,
                    'État satisfaisant' => 4,
                    'Pour pièces' => 5,
                ],
                ])
            ->add('city', TextType::class, [
                'attr' => ['class' => 'form-control']
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void {$resolver->setDefaults(['data_class' => ProductDto::class]);}
}
