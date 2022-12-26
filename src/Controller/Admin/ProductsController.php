<?php

namespace App\Controller\Admin;
use App\Entity\Products;
use App\Entity\User;
use App\Form\ProductsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/admin/produits', name: 'admin_products_')]
class ProductsController extends AbstractController{

    public function __construct(
        private ParameterBagInterface  $parameterBag,
        private EntityManagerInterface $entityManager,
    )
    {
    }
    #[Route('/', name: 'index')]
    public function index(): Response{
        return $this->render('admin/products/index.html.twig');
    }

    #[Route('/ajout', name: 'add', methods: ['GET', 'POST'])]
    public function add(Request $request, SluggerInterface $slugger): Response{
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $product = new Products();
        $productForm = $this->createForm(ProductsFormType::class, $product);

        $productForm->handleRequest($request);
        if ($productForm->isSubmitted() && $productForm->isValid()){
            $slug = $slugger->slug($product->getName());
            $product->setSlug($slug);

            $price = $product->getPrice() * 100;
            $product->setPrice($price);
            // debut traitement image
            $this->uploadImage($productForm, $slugger, $product);
            // fin traitement image
            $this->entityManager->persist($product);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_home_index');
        }
        $user = $this->getUser();
        $favoriteproduct = $this->entityManager->getRepository(User::class)->findBy(['id' => $user]);

        return $this->render('admin/products/add.html.twig', [
            'productForm' => $productForm->createView(),
            'favorite' => $favoriteproduct
        ]);
    }

    #[Route('/edition/{id}', name: 'edit')]
    public function edit(Products $product, Request $request, SluggerInterface $slugger): Response{
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', $product);

        $productsPath = $this->parameterBag->get('products_path');
        $productForm = $this->createForm(ProductsFormType::class, $product);

        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()){
            $slug = $slugger->slug($product->getName());
            $product->setSlug($slug);

            $price = $product->getPrice();
            $product->setPrice($price);
            // debut traitement image
            $this->uploadImage($productForm, $slugger, $product);
            // fin traitement image
            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_home_index');
        }
        $user = $this->getUser();
        $favoriteproduct = $this->entityManager->getRepository(User::class)->findBy(['id' => $user]);
        return $this->render('admin/products/edit.html.twig', [
            'productForm' => $productForm->createView(),
            'favorite' => $favoriteproduct
        ]);
    }

    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(Products $product): Response{
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', $product);
        $this->entityManager->remove($product);
        $this->entityManager->flush();

        // Supprimer ancien fichier
        $this->deleteImage($product);
        return $this->redirectToRoute('admin_products_index');
    }

    private function uploadImage(FormInterface $productForm, SluggerInterface $slugger, Products $product){
        $productsPath = $this->parameterBag->get('products_path');
        $productImage = $productForm->get('images')->getData();
        if ($productImage) {
            $originalFilename = pathinfo($productImage->getClientOriginalName(), PATHINFO_FILENAME);
            // Naming image
            if ($product->getImagePath()) {
                // Deleting old file
                $this->deleteImage($product);
            }
            $safeFilename = $slugger->slug($originalFilename);
            $newFileName = $safeFilename . '-' . uniqid() . '.' . $productImage->guessExtension();

            try {
                $productImage->move(
                    $productsPath,
                    $newFileName
                );
                $product->setImagePath($newFileName);
            } catch (\Exception $e) {
                dump($e);
            }
        }
    }

    /**
     * Deleting old unused file
     * @param Products $product
     * @return void
     */
    private function deleteImage(Products $product)
    {
        $pathToImage = $this->parameterBag->get('products_path') . DIRECTORY_SEPARATOR . $product->getImagePath();
        if (file_exists($pathToImage)) {
            unlink($pathToImage);
        }
    }
}