<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BloodCenterController extends AbstractController
{
    #[Route('/blood/center', name: 'app_blood_center')]
    public function index(): Response
    {
        return $this->render('blood_center/index.html.twig', [
            'controller_name' => 'BloodCenterController',
        ]);
    }
}
