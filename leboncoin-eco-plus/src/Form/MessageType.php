<?php

namespace App\Form;

use App\DTO\MessageDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('message', TextareaType::class, [
                'required' => true,
                'attr' => ['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void {$resolver->setDefaults(['data_class' => MessageDto::class,]);}
}
