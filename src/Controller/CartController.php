<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(CartService $cartService)
    {
        // On envoi au template les données du tableaux enrichi les exploitées à l'affichage
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'wineBoxQuantity' => $cartService->getWineBoxQuantity(),
            'total' => $cartService->getTotal()
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id, CartService $cartService)
    {      
        $cartService->add($id);

        return $this->redirectToRoute("cart_index");
    }
    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove($id, CartService $cartService) 
    {
        $cartService->remove($id);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/cart/remove_all/{id}", name="cart_remove_all")
     */
    public function remove_all($id, CartService $cartService) 
    {
        $cartService->remove_all($id);

        return $this->redirectToRoute("cart_index");
    }
}
