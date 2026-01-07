<?php

namespace App\Controller;

use App\Repository\BloodCenterRepository;
use App\Repository\DonationRepository;
use App\Repository\DonorProfileRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    #[Route('/test/{success}-{name}', name: 'test.show', requirements: ['name' =>'[a-z]+', 'success'=> '[a-z0-9]+'])]
    public function show(Request $request, string $name, string $success): Response
    {
        return $this->render('HomeTest/show.html.twig', [
            'name' => $name,
            'success' => $success,
            'demo' => "<h1>lhaj</h1>",
            'person' => [
                'smya' => 'smail',
                'la9ab' => 'sousou'
    ]
        ]);
    }
    //////////////////////////////////////////////////////////////////
    /// heres comes our projecttt
    ///
    ///
//    #[Route('/test/users', name :'test_users')]
//    public function users(UserRepository $repo): Response
//    {
//        $users = $repo->findAll();
//        $data = [];
//        foreach ($users as $user) {
//            $data[] = [
//                'id' => $user->getId(),
//                'email' => $user->getEmail(),
//                'roles' => $user->getRoles(),
//                'createdAt' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
//            ];
//        }
//
//        return $this->render('Users/index.html.twig', [
//            'users' => $data
//        ]);
////      return $this->json($data); //hadi kanet dual tet
//    }

    // our donorss
//    #[Route('/test/donors', name :'test_donors')]
//    public function donors(DonorProfileRepository $repo): Response
//    {
//        $donors = $repo->findAll();
//        $data = [];
//        foreach ($donors as $donor) {
//            $data[] = [
//                'id' => $donor->getId(),
//                'userEmail' => $donor->getUser()->getEmail(),
//                'fullName' => $donor->getUser()->getName(),
//                'bloodType' => $donor->getBloodType(),
//                'birthdate' => $donor->getBirthdate()->format('Y-m-d'),
//                'phoneNumber' => $donor->getPhoneNumber(),
//                'cine' => $donor->getCine()
//            ];
//        }
//        return $this->render('Donors/index.html.twig', [
//            'donors' => $data
//        ]);
//
////        return $this->json($data);
//    }

    // our donations
    #[Route('/test/donations', name :'test_donations')]
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

//        return $this->json($data);
    }

    // ohadu centers
    #[Route('/test/centers', name :'test_centers')]
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

//        return $this->json($data);
    }
}
