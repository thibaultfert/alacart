<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductComment;
use App\Form\ProductType;
use App\Form\ProductCommentType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/create", name="product_create")
     * @Route("/product/{id}/edit", name="product_edit") 
     */
    // Si c'est la 1ere route qui nous amène ici, l'objet $product sera null d'où la mention dans les param de la fct
    // Si c'est la 2eme route, grâce à l'id en paramètre, 
    // le parmaterConverter de symfony choisira par défaut l'objet $product d'après cet id
    public function formProduct(Product $product = null, Request $request, EntityManagerInterface $manager)
    {
        // Si l'objet $product est null (arrivée par 1ere route)
        if(!$product) {
            $product = new Product();
        }

        //formulaire de type ProductType (type crée grace à "php bin/console make:form")
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request); // L'objet form dispose d'un gestionnaire de requete
                                        // Analyse si soumis ou pas, si les champs sont remplis etc... 
                                        // Puis bind l'ensemble des champs dans l'objet associé (ici product)
        
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($product);
            $manager->flush();

            return $this->redirectToRoute('product_show_one', [
                'id' => $product->getId(),
                'type' => $product->getType()
                ]);
        }
                                        
        return $this->render('product/createProduct.html.twig', [
            'formProduct' => $form->createView(),
            'editMode' => $product->getId() !== null  // true si l'objet existe déjà (dans ce cas on veut éditer et non pas créer)
        ]);
    }
 
    /**
     * @Route("/product/{type}", name="product_show_by_type")
     */
    public function productShowByType($type, ProductRepository $repo): Response
    {
        $products = $repo->findByType($type);

        switch ($type) {
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

        return $this->render('product/product.html.twig', [
            'products' => $products,
            'pageTitle' => $pageTitle,
        ]);
    }

    /**
     * @Route("/product/{type}/{id}", name="product_show_one")
     */
    public function productShowOne($id, ProductRepository $repo, Request $request, EntityManagerInterface $manager)
    {
        $product = $repo->find($id);

        $productComment = new ProductComment();
        
        $form = $this->createForm(ProductCommentType::class, $productComment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $productComment->setCreatedAt(new \DateTime());   // On renseigne dans l'objet productComment à quelle date le commentaire a été crée
            $productComment->setProduct($product);            // On renseigne dans l'objet productComment à quel produit le commentaire doit être lié
            
            $manager->persist($productComment);
            $manager->flush();

            return $this->redirectToRoute('product_show_one', [
                'id' => $product->getId(),
                'type' => $product->getType()
                ]);
        }

        return $this->render('product/showOneProduct.html.twig', [
            'product' => $product,
            'productCommentForm' =>$form->createView()
        ]);
    }
}
