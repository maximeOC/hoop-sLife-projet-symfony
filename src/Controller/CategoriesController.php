<?php

namespace App\Controller;

use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/categories', name: 'app_categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/{slug}', name: 'listes')]
    public function list(Categories $categories): Response
    {
        $products = $categories->getProducts();

        return $this->render('categories/listes-produits.html.twig', [
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
