<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/equipe', name: 'app_teams_')]
class TeamsController extends AbstractController
{
    #[Route('/produits/{id}', name: 'index')]
    public function index(Request $request, ProductsRepository $productsRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $favoriteproduct = $entityManager->getRepository(User::class)->findBy(['id' => $user]);
        $productsByTeams = $productsRepository->findBy(['team' => $request->get('id')]);
        return $this->render('teams/index.html.twig', [
            'productsByTeams' => $productsByTeams,
            'favorite' => $favoriteproduct
        ]);
    }
}
