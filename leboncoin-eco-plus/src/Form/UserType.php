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
            ->add('name', TextType::class)
            ->add('firstname', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('passwordConfirm', PasswordType::class)
            ->add('address', TextType::class, [
                'required' => false
            ])
            ->add('zipcode', NumberType::class, [
                'required' => false
            ])
            ->add('state', TextType::class, [
                'required' => false
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
