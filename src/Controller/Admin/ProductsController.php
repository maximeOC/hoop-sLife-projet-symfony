<?php

namespace App\Controller\Admin;
use App\Entity\Products;
use App\Form\ProductsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/admin/produits', name: 'admin_products_')]
class ProductsController extends AbstractController{

    public function __construct(
        private readonly ParameterBagInterface  $parameterBag,
        private readonly EntityManagerInterface $entityManager,
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

        $productsPath = $this->parameterBag->get('products_path');

        $product = new Products();
        $productForm = $this->createForm(ProductsFormType::class, $product);

        $productForm->handleRequest($request);

        $productImage = $productForm->get('images')->getData();
        if ($productImage) {
            $originalFilename = pathinfo($productImage->getClientOriginalName(), PATHINFO_FILENAME);
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
        if ($productForm->isSubmitted() && $productForm->isValid()){
            $slug = $slugger->slug($product->getName());
            $product->setSlug($slug);

            $price = $product->getPrice() * 10000;
            $product->setPrice($price);

            $this->entityManager->persist($product);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_home_index');
        }

        return $this->render('admin/products/add.html.twig', [
            'productForm' => $productForm->createView()
        ]);
    }

    #[Route('/edition/{id}', name: 'edit')]
    public function edit(Products $product, EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger): Response{
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', $product);

        $productForm = $this->createForm(ProductsFormType::class, $product);

        $productForm->handleRequest($request);
        if ($productForm->isSubmitted() && $productForm->isValid()){
            $slug = $slugger->slug($product->getName());
            $product->setSlug($slug);

            $price = $product->getPrice();
            $product->setPrice($price);

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_home_index');
        }
        return $this->render('admin/products/edit.html.twig', [
            'productForm' => $productForm->createView()
        ]);
    }
    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(Products $products): Response{
        $this->denyAccessUnlessGranted('PRODUCT_DELETE', $products);
        return $this->render('admin/products/index.html.twig');
    }
}