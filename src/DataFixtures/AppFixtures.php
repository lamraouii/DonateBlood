<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\DonorProfile;
use App\Entity\BloodCenter;
use App\Entity\Donation;
use DateTimeImmutable;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;

class AppFixtures extends Fixture
{
//    private UserPasswordHasher $passwordHasher;
//
//    public function __construct(UserPasswordHasher $passwordHasher)
//    {
//        $this->passwordHasher = $passwordHasher;
//    }

    public function load(ObjectManager $manager): void
    {
        /* =======================
         * 1️⃣ BLOOD CENTERS
         * ======================= */
        $centers = [];

        $centerData = [
            ['Centre Régional Rabat', 'Rabat', 'Agdal', '0537000001'],
            ['Centre Casablanca', 'Casablanca', 'Maarif', '0522000002'],
            ['Centre Fes', 'Fes', 'Centre-ville', '0535000003'],
        ];

        foreach ($centerData as [$name, $city, $address, $phone]) {
            $center = new BloodCenter();
            $center->setName($name);
            $center->setCity($city);
            $center->setAddress($address);
            $center->setPhone($phone);
            $center->setIsActive(true);

            $manager->persist($center);
            $centers[] = $center;
        }

        /* =======================
         * 2️⃣ USERS + DONOR PROFILES
         * ======================= */
        $donors = [];

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setEmail("donor$i@test.com");
            $user->setRoles(['ROLE_DONOR']);
//            $user->setCreatedAt(new \DateTimeImmutable());
//            $user->setUpdatedAt(new \DateTimeImmutable());

//            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $hashedPassword = password_hash('password123', PASSWORD_BCRYPT);

            $user->setPassword($hashedPassword);

            $manager->persist($user);

            $donor = new DonorProfile();
            $donor->setUser($user);
            $donor->setBloodType(['A+', 'A-', 'B+', 'B-', 'AB+', 'O+'][array_rand(['A+', 'A-', 'B+', 'B-', 'AB+', 'O+'])]);
            $donor->setBirthDate(new DateTime('-' . rand(1, 365) . ' days'));
            $donor->setPhoneNumber("06123456789");
            $donor->setCine("U123456$i");
//            $donor->setIsEligible(true);

            $manager->persist($donor);
            $donors[] = $donor;
        }

        /* =======================
         * 3️⃣ DONATIONS
         * ======================= */
        for ($i = 0; $i < 25; $i++) {
            $donation = new Donation();
            $donation->setDonorProfile($donors[array_rand($donors)]);
            $donation->setBloodCenter($centers[array_rand($centers)]);
            $donation->setDonatedAt(new DateTime('-'. rand(1, 365) . ' days'));
            $donation->setQuantity(450); // ml
            $donation->setStatus('COMPLETED');
            $donation->setBloodType($donation->getDonorProfile()->getBloodType());

            $manager->persist($donation);
        }

        $manager->flush();
    }
}
