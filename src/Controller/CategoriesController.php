<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/categories', name: 'app_categories_')]
class CategoriesController extends AbstractController
{
   #[Route('/', name: 'index')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('categories/index.html.twig', [
            'categories' => $categoriesRepository->findAll()
        ]);
    }

//    #[Route('/{slug}', name: 'listes')]
//    public function list(Categories $categories): Response
//    {
//        $products = $categories->getProducts();
//
//        return $this->render('categories/listes-produits.html.twig', [
//            'categories' => $categories,
//            'products' => $products
//        ]);
//    }
}
