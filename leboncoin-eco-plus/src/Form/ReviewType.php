<?php

namespace App\Form;

use App\DTO\ReviewDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('rate', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0,
                    'max' => 5,
                    'hidden' => true
                ]
            ])
            ->add('comment', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control textarea']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void {$resolver->setDefaults(['data_class' => ReviewDto::class]);}
}
