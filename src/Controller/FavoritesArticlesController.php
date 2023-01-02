<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\User;
use App\Repository\ProductsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/favorites/articles', name: 'app_favorites_articles')]
class FavoritesArticlesController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(EntityManagerInterface $entityManager, Request $request, ProductsRepository $productsRepository): Response
    {
        $user = $this->getUser();
        $favoriteproduct = $entityManager->getRepository(User::class)->findBy(['id' => $user]);
        $productsbyFavorites= $productsRepository->findBy(['favoris' => $request->get('id')]);

        return $this->render('favorites_articles/index.html.twig', [
            'favorite' => $favoriteproduct,
            'productsbyFavorites' => $productsbyFavorites
        ]);
    }
}
