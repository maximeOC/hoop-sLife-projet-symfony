<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\User;
use App\Repository\ProductsRepository;
use App\Repository\SizesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, ProductsRepository $productsRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $favoriteproduct = $entityManager->getRepository(User::class)->findBy(['id' => $user]);
        $cart = $session->get("cart", []);
        $dataCart = [];
        $total = 0;

        foreach ( $cart as $id => $quantity){
            $product = $productsRepository->find($id);
            //faire un push dans le panier []
            $dataCart[] = [
                "product" => $product,
                "quantity" => $quantity
            ];
            $total += ($product->getPrice() * $quantity);
        }
        return $this->render('cart/index.html.twig', [
            'dataCart' => $dataCart,
            'total' => $total,
            'favorite' => $favoriteproduct
        ]);
    }

    #[Route('/add/{id}', name: 'add')]
    public function add(SessionInterface $session, Products $products)
    {
        $cart = $session->get("cart", []);
        $id = $products->getId();

        if(!empty($cart[$id])){
            $cart[$id]++;
            /**
             * [
             *  16 => ["none" => 1, "idTailleXL" => 3],
             *  19 => ["idTailleS" => 10, "idTailleXL" => 1]
             * ]
             */
        }else{
            $cart[$id] = 1;
        }
        $session->set("cart", $cart);
        return $this->redirectToRoute("cart_index");
    }

    #[Route('/remove/{id}', name: 'remove')]
    public function remove(SessionInterface $session, Products $products)
    {
        $cart = $session->get("cart", []);
        $id = $products->getId();

        if(!empty($cart[$id])){
            if($cart[$id] > 1){
                $cart[$id]--;
            }else{
                unset($cart[$id]);
            }
        }
        $session->set("cart", $cart);

        return $this->redirectToRoute("cart_index");
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(SessionInterface $session, Products $products)
    {
        $cart = $session->get("cart", []);
        $id = $products->getId();

        if(!empty($cart[$id])){
                unset($cart[$id]);
            }

        $session->set("cart", $cart);

        return $this->redirectToRoute("cart_index");
    }
    #[Route('/delete', name: 'delete_all')]
    public function deleteAll(SessionInterface $session)
    {
       $session->set('cart', []);
        return $this->redirectToRoute("cart_index");
    }
}
