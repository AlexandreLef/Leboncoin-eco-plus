<?php

namespace App\Form;

use App\DTO\SearchDto;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setAction('/product/list')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'required' => false,
                'empty_data' => null
            ])
            ->add('search', TextType::class, [
                'required' => false,
                'empty_data' => ''
            ])
            ->add('city', TextType::class, [
                'required' => false,
                'empty_data' => ''
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchDto::class,
        ]);
    }
}
