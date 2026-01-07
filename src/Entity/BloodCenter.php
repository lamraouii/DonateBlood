<?php

namespace App\Entity;

use App\Repository\BloodCenterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BloodCenterRepository::class)]
class BloodCenter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    private string $name ;

    #[ORM\Column(length: 255, nullable: false)]
    private string $city;

    #[ORM\Column(length: 255, nullable: false)]
    private string $address;

    #[ORM\Column(length: 20, nullable: false)]
    private string $phone;

    #[ORM\Column(type: 'boolean')]
    private bool $isActive = true;

    /**
     * @var Collection<int, Donation>
     */
    #[ORM\OneToMany(targetEntity: Donation::class, mappedBy: 'bloodCenter')]
    private Collection $donations;

    public function __construct()
    {
        $this->donations = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

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
            $donation->setBloodCenter($this);
        }

        return $this;
    }

    public function removeDonation(Donation $donation): static
    {
        if ($this->donations->removeElement($donation)) {
            // set the owning side to null (unless already changed)
            if ($donation->getBloodCenter() === $this) {
                $donation->setBloodCenter(null);
            }
        }

        return $this;
    }
}
