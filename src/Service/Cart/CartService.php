<?php

namespace App\Service\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {

    protected $session;
    protected $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function add(int $id) 
    {
        // Le panier créé ici est de type clef => val : id => quantity
        // On récuère le panier sauvegardé ou, si pas de panier, on y associe un tab vide
        $cart = $this->session->get('cart', []);
        
        // Si le produit est déjà dans le panier alors on incrémente sa quantité
        if (!empty($cart[$id])) {
            $cart[$id]++;
        }
        else {
           $cart[$id] = 1; 
        }

        // On actualise la donnée 'cart' liée à la session
        $this->session->set('cart', $cart);
    }

    public function remove(int $id) 
    {
        $cart = $this->session->get('cart', []);
        
        // Si le produit est bien dans le panier alors on décrémente sa quantité
        // Si la quantité du produit est égale à 1 alors on supprime l'item (unset)
        if ( $cart[$id] == 1) {
            unset($cart[$id]);
        } elseif (  $cart[$id] > 1) {
            $cart[$id]--;
        }

        // On actualise la donnée 'cart' liée à la session
        $this->session->set('cart', $cart);
    }

    public function remove_all(int $id) 
    {
        $cart = $this->session->get('cart', []);
        
        // Si le produit est déjà bien le panier alors on efface l'item (quelque soit sa quantité)
        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }

        // On actualise la donnée 'cart' liée à la session
        $this->session->set('cart', $cart);
    }

    public function getFullCart() : array 
    {
        // Le panier créé ici est de type clef => val : id => quantity
        // On récuère le panier sauvegardé ou, si pas de panier, on y associe un tab vide
        $cart = $this->session->get('cart', []);
        
        // Tab dont chaque case est un tab contenant le produit (+ ses infos) et la quantity
        $cartWithData = [];

        // On rempli le tableaux de tableaux en partant du tab $cart (de type id => quantity)
        foreach ($cart as $id => $quantity) {
            $cartWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];
        }

        return $cartWithData;

    }
    // Calcul du total du panier (prix)
    public function getTotal() : float 
    {
        $total = 0;

        foreach ($this->getFullCart() as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }

        return $total;
    }

    public function getWineBoxQuantity() : int
    {
        $wineBoxQuantity = 0;
        $cart = $this->session->get('cart', []);

        foreach ($cart as $id => $quantity) {
            $item = $this->productRepository->find($id);
            if (    $item->getType() == 'red_wine'
                ||  $item->getType() == 'white_wine'
                ||  $item->getType() == 'rose_wine'
                ||  $item->getType() == 'champagne') 
                {
                    $wineBoxQuantity += $quantity;
                }
        }
        return $wineBoxQuantity;
        
    }
}