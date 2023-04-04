<?php

namespace App\form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductPriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', ChoiceType::class, [
                'choices' => [
                    'Apple'  => 1,
                    'Banana' => 2,
                    'Durian' => 3,
                ]
//                'choices' => $this->getProductChoices(),
            ])
            ->add('taxNumber', TextType::class, [
                'label' => 'Tax Number',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
//            'data_class' => ProductPriceData::class,
        ]);
    }

//    private function getProductChoices(): array
}