<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\MainCategories;
use App\Entity\Products;
use App\Entity\User;
use App\Repository\CategoriesRepository;
use App\Repository\MainCategoriesRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/categories', name: 'app_categories_')]
#[ParamConverter('categories')]
class CategoriesController extends AbstractController
{
   #[Route('/{main_id}', name: 'index', methods: 'GET')]
   #[ParamConverter('mainCategories', options: ['mapping' => ['main_id' => 'id']])]
    public function index(MainCategories $mainCategories, CategoriesRepository $CategoriesRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $favoriteproduct = $entityManager->getRepository(User::class)->findBy(['id' => $user]);
        $detailCatMain = $CategoriesRepository->findByMainCategories($mainCategories->getId());
        return $this->render('categories/index.html.twig', [
            'maincategories' => $mainCategories,
            'detailCatMain' => $detailCatMain,
            'favorite' => $favoriteproduct
        ]);
    }
}
