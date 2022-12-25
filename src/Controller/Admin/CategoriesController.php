<?php

namespace App\Controller\Admin;
use App\Entity\Categories;
use App\Entity\User;
use App\Form\CategoriesFormType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/categories', name: 'admin_categories_')]
class CategoriesController extends AbstractController{

    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    #[Route('/ajouter', name: 'add')]
    public function index(Request $request){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $categories = new Categories();
        $categoriesForm = $this->createForm(CategoriesFormType::class, $categories);

        $categoriesForm->handleRequest($request);
        if($categoriesForm->isSubmitted() && $categoriesForm->isValid()){
            $this->entityManager->persist($categories);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_home_index');
        }
        $user = $this->getUser();
        $favoriteproduct = $this->entityManager->getRepository(User::class)->findBy(['id' => $user]);

        return $this->render('admin/Categories/add.html.twig', [
            'categoriesForm' => $categoriesForm->createView(),
            'favorite' => $favoriteproduct
        ]);
        }
}