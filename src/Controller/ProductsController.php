<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/produits', name: 'products_')]
class ProductsController extends AbstractController
{
    #[Route('/categorie/{id}', name: 'categorie_id')]
    public function index(Request $request, ProductsRepository $productsRepository): Response
    {
        $products = $productsRepository->findBy(['categories' => $request->get('id')]);
        return $this->render('products/index.html.twig', [
            'products' => $products,

        ]);
    }

    #[Route('/{slug}', name: 'details')]
    public function details(ProductsRepository $productsRepository, Request $request): Response
    {
        $productId = $productsRepository->findOneBy(['slug' => $request->get('slug')]);
        $product = $productsRepository->find($productId->getId());
        dump($product);
        return $this->render('products/detail.html.twig', [
            'product' => $product,
        ]);
    }
}
