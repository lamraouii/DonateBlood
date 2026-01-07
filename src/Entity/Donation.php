<?php

namespace App\Entity;

use App\Repository\DonationRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: DonationRepository::class)]
class Donation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'donations')]
    #[ORM\JoinColumn(nullable: false)]
    private DonorProfile $donorProfile;

    #[ORM\Column(length: 4, nullable: true)]
    private ?string $bloodType=null;

    #[ORM\Column(nullable: false)]
    private int $quantity ;

    #[ORM\Column(type: "date", nullable: false)]
    private \DateTime $donatedAt;

    #[ORM\Column(length: 20, nullable: false)]
    private string $status ;

    #[ORM\ManyToOne(inversedBy: 'donations')]
    #[ORM\JoinColumn(nullable: false)]
    private BloodCenter $bloodCenter;

    public function getId(): ?int
    {
        return $this->id;
    }

//    public function setId(int $id): static
//    {
//        $this->id = $id;
//
//        return $this;
//    }

    public function getDonorProfile(): DonorProfile
    {
        return $this->donorProfile;
    }

    public function setDonorProfile(DonorProfile $donorProfile): static
    {
        $this->donorProfile = $donorProfile;

        return $this;
    }

    public function getBloodType(): string
    {
        return $this->bloodType;
    }

    public function setBloodType(string $bloodType): static
    {
        $this->bloodType = $bloodType;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getDonatedAt(): ?\DateTime
    {
        return $this->donatedAt;
    }

    public function setDonatedAt(?\DateTime $donatedAt): static
    {
        $this->donatedAt = $donatedAt;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getBloodCenter(): BloodCenter
    {
        return $this->bloodCenter;
    }

    public function setBloodCenter(BloodCenter $bloodCenter): static
    {
        $this->bloodCenter = $bloodCenter;

        return $this;
    }
}
