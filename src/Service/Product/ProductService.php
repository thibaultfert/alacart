<?php

namespace App\Service\Product;

use App\Repository\ProductRepository;

class ProductService {

    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getOneItemById(int $id)
    {
        $product = $this->productRepository->find($id);

        return $product; 
    }
    
    public function getAllItemsByType(string $productType) : array
    {
        $products = $this->productRepository->findByType($productType);

        return $products;
    }

    public function getProductPageTitle(string $productType) : string
    {       
        switch ($productType) {
            case 'red_wine':
                $pageTitle = "Vins Rouges";
                break;
            case 'white_wine':
                $pageTitle = "Vins Blancs";
                break;
            case 'rose_wine':
                $pageTitle = "Vins Roses";
                break;
            case 'champagne':
                $pageTitle = "Champagnes et Bulles";
                break;
            case 'ham':
                $pageTitle = "Jambon Serrano";
                break;
            case 'foie_gras':
                $pageTitle = "Foies Gras et Terrines";
                break;
            case 'oil':
                $pageTitle = "Huiles";
                break;          
            default:
                $pageTitle = "Alacart' - Vins & Gourmandises";
                break;
        }

        return $pageTitle;
    }
}