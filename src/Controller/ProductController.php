<?php

namespace App\Controller;

use App\Entity\Drink;
use App\Entity\DrinkComment;
use App\Form\DrinkType;
use App\Form\DrinkCommentType;
use App\Repository\DrinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/drink/create_drink", name="create_drink")
     * @Route("/product/drink/{id}/edit_drink", name="edit_drink") 
     */
    // Si c'est la 1ere route qui nous amène ici, l'objet $drink sera null d'où la mention dans les param de la fct
    // Si c'est la 2eme route, grâce à l'id en paramètre, 
    // le parmaterConverter de symfony choisira par défaut l'objet $drink d'après cet id
    public function formDrink(Drink $drink = null, Request $request, EntityManagerInterface $manager)
    {
        // Si l'objet $drink est null (arrivée par 1ere route)
        if(!$drink) {
            $drink = new Drink();
        }

        //formulaire de type DrinkType (type crée grace à "php bin/console make:form")
        $form = $this->createForm(DrinkType::class, $drink);

        $form->handleRequest($request); // L'objet form dispose d'un gestionnaire de requete
                                        // Analyse si soumis ou pas, si les champs sont remplis etc... 
                                        // Puis bind l'ensemble des champs dans l'objet associé (ici drink)
        
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($drink);
            $manager->flush();

            return $this->redirectToRoute('show_one_drink', [
                'id' => $drink->getId(),
                'type' => $drink->getType()
                ]);
        }
                                        
        return $this->render('product/createDrink.html.twig', [
            'formDrink' => $form->createView(),
            'editMode' => $drink->getId() !== null  // true si l'objet existe déjà (dans ce cas on veut éditer et non pas créer)
        ]);
    }
 
    /**
     * @Route("/product/drink/{type}", name="drink")
     */
    public function drink($type, DrinkRepository $repo): Response
    {
        $drinks = $repo->findByType($type);

        return $this->render('product/drink.html.twig', [
            'drinks' => $drinks,
            'type' => $type
        ]);
    }

    /**
     * @Route("/product/drink/{type}/{id}", name="show_one_drink")
     */
    public function show($id, DrinkRepository $repo, Request $request, EntityManagerInterface $manager)
    {
        $drink = $repo->find($id);

        $drinkComment = new DrinkComment();
        
        $form = $this->createForm(DrinkCommentType::class, $drinkComment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $drinkComment->setCreatedAt(new \DateTime());   // On renseigne dans l'objet drinkComment à quelle date le commentaire a été crée
            $drinkComment->setDrink($drink);                // On renseigne dans l'objet drinkComment à quel produit le commentaire doit être lié
            
            $manager->persist($drinkComment);
            $manager->flush();

            return $this->redirectToRoute('show_one_drink', [
                'id' => $drink->getId(),
                'type' => $drink->getType()
                ]);
        }

        return $this->render('product/showOneDrink.html.twig', [
            'drink' => $drink,
            'drinkCommentForm' =>$form->createView()
        ]);
    }
}
