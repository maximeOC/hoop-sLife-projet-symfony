<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\MainCategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MainCategoriesRepository $mainCategoriesRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'categories' => $mainCategoriesRepository->findAll()
        ]);
    }

    #[Route('/{id}', name: 'app_home_id')]
    public function id(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'categories' => $categoriesRepository->findAll()
        ]);
    }
}
