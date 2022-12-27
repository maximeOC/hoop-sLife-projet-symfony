<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Products;
use App\Entity\User;
use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/all/products', name: 'app_all_products_')]
#[ParamConverter ('Products')]
class AllProductsController extends AbstractController
{
    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    #[Route('/', name: 'index')]
    #[ParamConverter('')]
    public function index(
        ProductsRepository $productsRepository,
        EntityManagerInterface $entityManager,
        CategoriesRepository $categoriesRepository,
        Request $request,
        PaginatorInterface $paginator,
    ): Response
    {
        $user = $this->getUser();
        $favoriteproduct = $entityManager->getRepository(User::class)->findBy(['id' => $user]);

        $filters = $request->get("categories");

        $productByCategorie = $productsRepository->getCategories($filters);

        $produitPaginated = $paginator->paginate(
            $productByCategorie,
            $request->query->getInt('page', 1),
            3
        );

        $allProducts = $productsRepository->getTotalProducts($filters);

        if($request->get('ajax')){
            return new JsonResponse([
                'content' => $this->renderView('all_products/_allTheProducts.html.twig', [
                    'produitPaginated' => $produitPaginated,
                    'allProducts' => $allProducts,
                    'favorite' => $favoriteproduct
                ])
            ]);
        }

        return $this->render('all_products/index.html.twig', [
//            'allProducts' => $allProducts,
            'produitPaginated' => $produitPaginated,
            'allCategories' => $categoriesRepository->findAll(),
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
