<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Entity\ProductComment;
use App\Form\ProductCommentType;
use App\Service\User\UserService;
use App\Service\Product\ProductService;
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
    public function productShowByType($type, ProductService $productService): Response
    {
        return $this->render('product/product.html.twig', [
            'products' => $productService->getAllItemsByType($type),
            'pageTitle' => $productService->getProductPageTitle($type)
        ]);
    }

    /**
     * @Route("/product/{type}/{id}", name="product_show_one")
     * @Route("/product/{type}/{id}/{userId}", name="product_add_comment")
     */
    // Si c'est la 1ere route qui nous amène ici, c'est une ouverture de la page sans particularité
    // Si c'est la 2eme route, c'est qu'un form de comment a été soumis
    // c'est dans ce 2eme cas que le $userId sera exploité
    public function productShowOne($id, $userId = null, ProductService $productService, UserService $userService, Request $request, EntityManagerInterface $manager)
    {
        $productComment = new ProductComment();
        
        $commentForm = $this->createForm(ProductCommentType::class, $productComment);

        $commentForm->handleRequest($request);

        if($commentForm->isSubmitted() && $commentForm->isValid() && $userId) {
                $productComment->setAuthor($userService->getOneItemById($userId)->getFirstName());
                $productComment->setCreatedAt(new \DateTime());                               // On renseigne dans l'objet productComment à quelle date le commentaire a été crée
                $productComment->setProduct($productService->getOneItemById($id));            // On renseigne dans l'objet productComment à quel produit le commentaire doit être lié
                
                $manager->persist($productComment);
                $manager->flush();

                $this->addFlash('success','Merci pour votre commentaire !');

                return $this->redirectToRoute('product_show_one', [
                    'id' => $id,
                    'type' => $productService->getOneItemById($id)->getType()
                    ]);
        }
        return $this->render('product/showOneProduct.html.twig', [
            'product' => $productService->getOneItemById($id),
            'productCommentForm' => $commentForm->createView(),
            'userId'=> $userId
        ]);
    }
}