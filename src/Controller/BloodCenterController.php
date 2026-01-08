<?php

namespace App\Controller;

use App\Entity\BloodCenter;
use App\Form\BloodCenterType;
use App\Repository\BloodCenterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/centers')]
final class BloodCenterController extends AbstractController
{
    #[Route('/', name :'centers_list')]
    public function centers(BloodCenterRepository $repo): Response
    {
        $centers = $repo->findAll();
        $data = [];
        foreach ($centers as $center) {
            $data[] = [
                'id' => $center->getId(),
                'name' => $center->getName(),
                'city' => $center->getCity(),
                'address' => $center->getAddress(),
                'phone' => $center->getPhone(),
                'isActive' => $center->getisActive(),
            ];
        }

        return $this->render('Centers/index.html.twig', [
            'centers' => $data
        ]);
    }

    #[Route('/new', name: 'centers_add')]
    public function new(Request $request, EntityManagerInterface $em)
    {
        $center = new BloodCenter();
        $form = $this->createForm(BloodCenterType::class, $center);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($center);
            $em->flush();

            $this->addFlash('success', 'Center created');
            return $this->redirectToRoute('centers_list');
        }

        return $this->render('centers/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'centers_edit')]
    public function edit(Request $request, BloodCenter $center, EntityManagerInterface $em)
    {
        $form = $this->createForm(BloodCenterType::class, $center);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush(); // no persist
            $this->addFlash('success', 'Center updated');
            return $this->redirectToRoute('centers_list');
        }

        return $this->render('centers/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'centers_delete', methods: ['POST'])]
    public function delete(Request $request, BloodCenter $center, EntityManagerInterface $em)
    {
        if ($this->isCsrfTokenValid('delete'.$center->getId(), $request->request->get('_token'))) {
            $em->remove($center);
            $em->flush();
            $this->addFlash('warning', 'Center deleted');
        }

        return $this->redirectToRoute('centers_list');
    }

    #[Route('/map', name: 'centers_map')]
    public function map(): Response
    {
        return $this->render('centers/map.html.twig');
    }


}
