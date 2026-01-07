<?php

namespace App\Controller;

use App\Entity\Donation;
use App\Form\DonationType;
use App\Repository\DonationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/donation')]
final class DonationController extends AbstractController
{
    #[Route('/', name :'donations_list')]
    public function donations(DonationRepository $repo): Response
    {
        $donations = $repo->findAll();
        $data = [];
        foreach ($donations as $donation) {
            $data[] = [
                'id' => $donation->getId(),
                'donorEmail' => $donation->getDonorProfile()->getUser()->getEmail(),
                'bloodType' => $donation->getBloodType(),
                'quantity' => $donation->getQuantity(),
                'donatedAt' => $donation->getDonatedAt()->format('Y-m-d H:i:s'),
                'status' => $donation->getStatus(),
                'bloodCenter' => $donation->getBloodCenter()->getName(),
            ];
        }
        return $this->render('Donations/index.html.twig', [
            'donations' => $data
        ]);

    }

    #[Route('/new', name: 'donations_add')]
    public function newDonation(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $donation = new Donation();
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($donation);
            $em->flush();

            $this->addFlash('success', 'Donation added');
            return $this->redirectToRoute('donations_list');
        }

        return $this->render('donations/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'donations_edit')]
    public function editDonation(
        Request $request,
        Donation $donation,
        EntityManagerInterface $em
    ): Response {
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush(); // no persist
            $this->addFlash('success', 'Donation updated');
            return $this->redirectToRoute('donations_list');
        }

        return $this->render('donations/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'donations_delete', methods: ['POST'])]
    public function deleteDonation(Request $request, Donation $donation, EntityManagerInterface $em) : Response
    {
        if ($this->isCsrfTokenValid('delete'.$donation->getId(), $request->request->get('_token'))) {
            $em->remove($donation);
            $em->flush();
            $this->addFlash('warning', 'Donation deleted');
        }

        return $this->redirectToRoute('donations_list');
    }

}
