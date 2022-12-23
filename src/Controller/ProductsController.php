<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Images;
use App\Entity\Products;
use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


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
        return $this->render('products/detail.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     */
    #[Route('/favoris/ajout/{id}', name: 'add_favoris')]
    public function addFavoris(Products $products, EntityManagerInterface $entityManager, Request $request, ProductsRepository $productsRepository){
        $products->addFavori($this->getUser());
//        $product = $productsRepository->findBy(['categories' => $request->get('id')]);

        $entityManager->persist($products);
        $entityManager->flush();
        return $this->redirectToRoute($request->attributes->get('products_categorie_id'));
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\Exception\ORMException
     * @ParamConverter("category", class="App\Entity\Categories")
     */
    #[Route('/favoris/retrait/{id}', name: 'remove_favoris')]
    public function removeFavoris(Products $products, EntityManagerInterface $entityManager, Categories $categories){
        $products->removeFavori($this->getUser());

        $entityManager->persist($products);
        $entityManager->flush();
        return $this->redirectToRoute('products_categorie_id', array('id' => $categories->getId()));
    }
}
