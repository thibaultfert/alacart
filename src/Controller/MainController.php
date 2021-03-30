<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Drink;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('main/home.html.twig');
    }

    /**
     * @Route("/{type}", name="drink")
     */
    public function drink($type): Response
    {
        $repo = $this->getDoctrine()->getRepository(Drink::class);

        $drinks = $repo->findByType($type);

        return $this->render('main/drink.html.twig', [
            'drinks' => $drinks,
            'type' => $type
        ]);
    }

    /**
     * @Route("/main/12", name="main_show")
     */
    public function show()
    {
        return $this->render('main/show.html.twig');
    }
}
