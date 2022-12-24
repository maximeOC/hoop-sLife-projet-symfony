<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\User;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/all/products', name: 'app_all_products_')]
class AllProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProductsRepository $productsRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $favoriteproduct = $entityManager->getRepository(User::class)->findBy(['id' => $user]);
        return $this->render('all_products/index.html.twig', [
            'allProducts' => $productsRepository->findAll(),
            'favorite' => $favoriteproduct
        ]);
    }
    #[Route('/favoris/ajout/{id}', name: 'add_favoris')]
    public function addFavoris(Products $products, EntityManagerInterface $entityManager){
        $products->addFavori($this->getUser());
//        dd($products->getCategories()->getId());
        $entityManager->persist($products);
        $entityManager->flush();
        return $this->redirectToRoute('app_all_products_index');
    }


    #[Route('/favoris/retrait/{id}', name: 'remove_favoris')]
    public function removeFavoris(Products $products, EntityManagerInterface $entityManager, ProductsRepository $productsRepository): Response{
        $products->removeFavori($this->getUser());

        $entityManager->persist($products);
        $entityManager->flush();
        return $this->redirectToRoute('products_categorie_id', array('id' => $products->getCategories()->getId()));
    }
}
