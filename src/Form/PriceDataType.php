<?php

namespace App\Form;

use App\Data\PriceData;

use App\Entity\Categories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceDataType extends AbstractType
{

<<<<<<< HEAD
public function buildForm(FormBuilderInterface $builder, array $options)
{
=======
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
>>>>>>> testProductByteam
        $builder
//            ->add('categories', EntityType::class, [
//                'label' => false,
//                'required' => false,
//                'class' => Categories::class,
//                'expanded' => true,
//                'multiple' => true
//            ])
<<<<<<< HEAD
        ->add('min', NumberType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
            'placeholder' => 'Prix min'
        ]
])
        ->add('max', NumberType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
            'placeholder' => 'Prix max'
        ]
        ]);
}

public function configureOptions(OptionsResolver $resolver)
{
=======
            ->add('min', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix min'
                ]
            ])
            ->add('max', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix max'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
>>>>>>> testProductByteam
        $resolver->setDefaults([
            'data_class' => PriceData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
<<<<<<< HEAD
}

public function getBlockPrefix(): string
{
    return '';
}
=======
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
>>>>>>> testProductByteam

}