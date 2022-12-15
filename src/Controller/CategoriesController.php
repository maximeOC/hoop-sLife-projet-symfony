<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\MainCategories;
use App\Entity\Products;
use App\Repository\CategoriesRepository;
use App\Repository\MainCategoriesRepository;
use App\Repository\ProductsRepository;
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
    public function index(MainCategories $mainCategories, CategoriesRepository $CategoriesRepository): Response
    {
        $detailCatMain = $CategoriesRepository->findByMainCategories($mainCategories->getId());
        return $this->render('categories/index.html.twig', [
            'maincategories' => $mainCategories,
            'detailCatMain' => $detailCatMain
        ]);
    }
}
