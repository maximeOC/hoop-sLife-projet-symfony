<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, ProductsRepository $productsRepository): Response
    {
        $cart = $session->get("cart", []);
        $dataCart = [];
        $total = 0;

        foreach ( $cart as $id => $quantity){
            $product = $productsRepository->find($id);
            //faire un push dans le panier
            $dataCart[] = [
                "product" => $product,
                "quantity" => $quantity
            ];
            $total += ($product->getPrice() * $quantity) / 100;
        }

        return $this->render('cart/index.html.twig', [
            'dataCart' => $dataCart,
            'total' => $total
        ]);
    }

    #[Route('/add/{id}', name: 'add')]
    public function add(SessionInterface $session, Products $products)
    {
        $cart = $session->get("cart", []);
        $id = $products->getId();

        if(!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }
        $session->set("cart", $cart);
        return $this->redirectToRoute("cart_index");
    }
}