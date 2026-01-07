<?php

namespace App\Controller;

use App\Repository\DonorProfileRepository;
use App\Repository\DonationRepository;
use App\Repository\BloodCenterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(
        DonorProfileRepository $donorRepo,
        DonationRepository $donationRepo,
        BloodCenterRepository $centerRepo
    ): Response
    {
        // Total donors
        $totalDonors = $donorRepo->count([]);

        // Total donations
        $totalDonations = $donationRepo->count([]);

        // Blood stock per type (sum of quantity grouped by bloodType)
        $bloodStock = $donationRepo->createQueryBuilder('d')
            ->select('d.bloodType, SUM(d.quantity) as total')
            ->groupBy('d.bloodType')
            ->getQuery()
            ->getResult();

        // Donations per center (count)
        $donationsPerCenter = $donationRepo->createQueryBuilder('d')
            ->select('IDENTITY(d.bloodCenter) as centerId, COUNT(d.id) as total')
            ->groupBy('d.bloodCenter')
            ->getQuery()
            ->getResult();

        // Get center names
        $centers = $centerRepo->findAll();
        $centerMap = [];
        foreach ($centers as $c) {
            $centerMap[$c->getId()] = $c->getName();
        }

        return $this->render('dashboard/index.html.twig', [
            'totalDonors' => $totalDonors,
            'totalDonations' => $totalDonations,
            'bloodStock' => $bloodStock,
            'donationsPerCenter' => $donationsPerCenter,
            'centerMap' => $centerMap,
        ]);
    }
}
