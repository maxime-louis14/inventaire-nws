<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\Column(type: TYPES::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $rendered = null;

    #[ORM\Column(type: TYPES::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $loandate = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $isrenderd;

    #[ORM\ManyToOne(targetEntity: Materiel::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private $product;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $idapi;

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

    public function __construct()
    {
        $this->date = new \DateTime('now');
    }

    public function getRendered(): ?\DateTimeInterface
    {
        return $this->rendered;
    }

    public function setRendered(\DateTimeInterface $rendered): self
    {
        $this->rendered = $rendered;

        return $this;
    }

    public function getLoandate(): ?\DateTimeInterface
    {
        return $this->loandate;
    }

    public function setLoandate(\DateTimeInterface $loandate): self
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

    // public function __toString()
    // {
    //     return $this->getId();
    // }

    public function getIdapi(): ?int
    {
        return $this->idapi;
    }

    public function setIdapi(?int $idapi): self
    {
        $this->idapi = $idapi;

        return $this;
    }
}
