<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'datetime_immutable')]
    private $rendered;

    #[ORM\Column(type: 'datetime_immutable')]
    private $loandate;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $isrenderd;

    #[ORM\ManyToOne(targetEntity: Materiel::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRendered(): ?\DateTimeImmutable
    {
        return $this->rendered;
    }

    public function setRendered(\DateTimeImmutable $rendered): self
    {
        $this->rendered = $rendered;

        return $this;
    }

    public function getLoandate(): ?\DateTimeImmutable
    {
        return $this->loandate;
    }

    public function setLoandate(\DateTimeImmutable $loandate): self
    {
        $this->loandate = $loandate;

        return $this;
    }

    public function isIsrenderd(): ?bool
    {
        return $this->isrenderd;
    }

    public function setIsrenderd(?bool $isrenderd): self
    {
        $this->isrenderd = $isrenderd;

        return $this;
    }

    public function getProduct(): ?Materiel
    {
        return $this->product;
    }

    public function setProduct(?Materiel $product): self
    {
        $this->product = $product;

        return $this;
    }
}
