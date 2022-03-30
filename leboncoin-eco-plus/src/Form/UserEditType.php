<?php

namespace App\Form;

use App\DTO\UserEditDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('email', EmailType::class, [
                'disabled' => true,
            ])
            ->add('address', TextType::class, [
                'required' => false,
            ])
            ->add('zipcode', NumberType::class, [
                'html5' => true,
                'required' => false,
            ])
            ->add('state', TextType::class, [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserEditDto::class,
            'attr' => ['class' => 'row g-3']
        ]);
    }
}
