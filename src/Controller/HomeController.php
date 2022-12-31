<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CategoriesRepository;
use App\Repository\MainCategoriesRepository;
use App\Repository\TeamsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/', name: 'app_home_')]
class HomeController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(MainCategoriesRepository $mainCategoriesRepository, EntityManagerInterface $entityManager, TeamsRepository $teamsRepository): Response
    {
        $user = $this->getUser();
        $favoriteproduct = $entityManager->getRepository(User::class)->findBy(['id' => $user]);

        return $this->render('home/index.html.twig', [
            'mainCategories' => $mainCategoriesRepository->findAll(),
            'teams' => $teamsRepository->findAll(),
            'favorite' => $favoriteproduct
        ]);
    }


}
