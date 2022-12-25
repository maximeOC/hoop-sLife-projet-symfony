<?php

namespace App\Form;

use App\Entity\Products;
use App\Entity\Sizes;
use App\Repository\SizesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', options: [
                'label' => 'Nom du produit'
            ])
            ->add('price', options: [
                'label' => 'Prix'
            ])
            ->add('description', options: [
                'label' => 'description'
            ])
            ->add('categories')
            ->add('images', FileType::class, [
                'mapped' => false
            ]);
//            ->add('size', EntityType::class, [
//                'class' => Sizes::class,
//                'query_builder' => function (SizesRepository $r) {
//                            return $r->createQueryBuilder('s')
//                        ->orderBy('s.name', 'ASC');
//                            },
//                'choice_label' => 'name',
//                'multiple' => false,
//            ])
//            ->add('submit', SubmitType::class, [
//                'attr' => [
//                'class' => 'btn btn-primary mt-4'
//                ],
//    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
