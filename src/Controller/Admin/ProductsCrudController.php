<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductsCrudController extends AbstractCrudController
{

    public const baseImages = '/assets/images/products';
    public const dirImages = '/public/build/images/products';

    public static function getEntityFqcn(): string
    {
        return Products::class;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('categories')->renderAsNativeWidget(),
            TextField::new('name'),
            MoneyField::new('price')->setCurrency('EUR'),
            ImageField::new('images')
                ->setBasePath(self::baseImages)
                ->setUploadDir(self::dirImages),
            TextEditorField::new('description'),
            IntegerField::new('stock')
        ];
    }

}
