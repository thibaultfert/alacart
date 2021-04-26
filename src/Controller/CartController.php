<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Service\Cart\CartService;
use App\Service\User\UserService;
use App\Service\Contact\ContactService;
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
        return $this->render('cart/cart.html.twig', [
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

    /**
     * @Route("/cart/send/{id}", name="cart_send")
     */
    public function send($id, UserService $userService, ContactService $contactService, CartService $cartService) 
    {
        $user = $userService->getOneItemById($id);
        $contact = new Contact;
        $contact->setFirstName($user->getFirstName());
        $contact->setLastName($user->getLastName());
        $contact->setEmail($user->getEmail());

        $items = $cartService->getFullCart();
        $total = $cartService->getTotal();

        $contactService->sendCartEmail($contact, $items, $total);
        $this->addFlash('success','Votre liste a bien été envoyé, nous vous contacterons au plus vite !');
        return $this->redirectToRoute('main_home');
    }
}
