<?php

namespace App\Controller;

use App\Entity\DonorProfile;
use App\Form\DonorProfileType;
use App\Repository\DonorProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/donors')]
final class DonorProfileController extends AbstractController
{

    #[Route('/', name :'donors_list')]
    public function donors(DonorProfileRepository $repo): Response
    {
        $donors = $repo->findAll();
        $data = [];
        foreach ($donors as $donor) {
            $data[] = [
                'id' => $donor->getId(),
                'userEmail' => $donor->getUser()->getEmail(),
                'fullName' => $donor->getUser()->getName(),
                'bloodType' => $donor->getBloodType(),
                'birthdate' => $donor->getBirthdate()->format('Y-m-d'),
                'phoneNumber' => $donor->getPhoneNumber(),
                'cine' => $donor->getCine()
            ];
        }
        return $this->render('Donors/index.html.twig', [
            'donors' => $data
        ]);

//        return $this->json($data);
    }
    #[Route('/add', name: "donors_add")]
    public function addDonors(EntityManagerInterface $em, Request $request):Response
    {
        $donor = new DonorProfile();
        $form = $this->createForm(DonorProfileType::class,$donor);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($donor);
            $em->flush();

            $this->addFlash('success','donor created succfully');
            return $this->redirectToRoute('donors_list');
        }
        return $this->render('Donors/new.html.twig',[
            'form'=> $form,
        ]);

    }

    #[Route('/{id}/edit', name: 'donors_edit')]
    public function editDonor(
        Request $request,
        DonorProfile $donor,
        EntityManagerInterface $em
    ):Response {
        $form = $this->createForm(DonorProfileType::class, $donor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Donor updated');
            return $this->redirectToRoute('donors_list');
        }

        return $this->render('donors/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'donors_delete', methods: ['POST'])]
    public function deleteDonor(
        Request $request,
        DonorProfile $donor,
        EntityManagerInterface $em
    ): Response {
        if ($this->isCsrfTokenValid('delete'.$donor->getId(), $request->request->get('_token'))) {
            $em->remove($donor);
            $em->flush();
            $this->addFlash('warning', 'Donor deleted');
        }

        return $this->redirectToRoute('donors_list');
    }


}
