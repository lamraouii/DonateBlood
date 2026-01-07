<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;


class HomeController extends AbstractController {



    #[Route('/', name : "landing_page")]
    public function index(): Response
    {
        return new Response('Salam Alikum Lhaj');
//          return new Response($this->twig->render(''));

    }

}
