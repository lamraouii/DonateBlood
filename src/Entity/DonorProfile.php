<?php

namespace App\Entity;

use App\Repository\DonorProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonorProfileRepository::class)]
class DonorProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 4, nullable: false)]
    private string $bloodType ;

    #[ORM\Column(type: "date")]
    private ?\DateTime $birthdate = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phoneNumber ;

    #[ORM\Column(length: 10, nullable: false, unique: true)]
    private string $cine;

    /**
     * @var Collection<int, Donation>
     */
    #[ORM\OneToMany(targetEntity: Donation::class, mappedBy: 'donorProfile')]
    private Collection $donations;

    public function __construct()
    {
        $this->donations = new ArrayCollection();
        $this->birthdate = new \dateTime();
    }

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBloodType(): ?string
    {
        return $this->bloodType;
    }

    public function setBloodType(string $bloodType): static
    {
        $this->bloodType = $bloodType;

        return $this;
    }

    public function getBirthdate(): ?\DateTime
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTime $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getCine(): ?string
    {
        return $this->cine;
    }

    public function setCine(string $cine): static
    {
        $this->cine = $cine;

        return $this;
    }

    /**
     * @return Collection<int, Donation>
     */
    public function getDonations(): Collection
    {
        return $this->donations;
    }

    public function addDonation(Donation $donation): static
    {
        if (!$this->donations->contains($donation)) {
            $this->donations->add($donation);
            $donation->setDonorProfile($this);
        }

        return $this;
    }

    public function removeDonation(Donation $donation): static
    {
        if ($this->donations->removeElement($donation)) {
            // set the owning side to null (unless already changed)
            if ($donation->getDonorProfile() === $this) {
                $donation->setDonorProfile(null);
            }
        }

        return $this;
    }
}
