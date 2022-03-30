<?php

namespace App\Form;

use App\DTO\UserDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('firstname', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('password', PasswordType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('passwordConfirm', PasswordType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('address', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('zipcode', NumberType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('state', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserDto::class,
            'attr' => ['class' => 'row g-3']
        ]);
    }
}
