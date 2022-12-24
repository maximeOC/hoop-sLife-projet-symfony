<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CategoriesRepository;
use App\Repository\MainCategoriesRepository;
use App\service\NbaApi;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/', name: 'app_home_')]
class HomeController extends AbstractController
{
//    public function __construct(
//        private NbaApi $nbaApi
//    )
//    {
//    }


    #[Route('/', name: 'index')]
    public function index(MainCategoriesRepository $mainCategoriesRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $favoriteproduct = $entityManager->getRepository(User::class)->findBy(['id' => $user]);

        return $this->render('home/index.html.twig', [
            'mainCategories' => $mainCategoriesRepository->findAll(),
            'favorite' => $favoriteproduct
        ]);
    }


}
