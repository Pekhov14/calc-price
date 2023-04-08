<?php

namespace App\form;

use App\Validator\CountryCodeError;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductPriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', ChoiceType::class, [
                'label' => false,
                'choices' => $options['products'],
                'attr' => [
                    'class' => 'form-select mb-3',
                ],
            ])
            ->add('taxNumber', TextType::class, [
                'label' => false,
                'constraints' => [
                    new CountryCodeError(),
                ],
                'attr' => [
                    'placeholder' => 'Tax номер',
                    'class' => 'form-control mb-3',
                ],

            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Подсчет',
                'attr' => [
                    'class' => 'btn btn-primary form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'products' => []
        ]);
    }
}