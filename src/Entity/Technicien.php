<?php

namespace App\Entity;

use App\Repository\TechnicienRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: TechnicienRepository::class)]
#[ApiResource]
class Technicien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $organisation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(nullable: true)]
    private ?int $idZammad = null;

    #[ORM\Column]
    private ?int $organizationId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getOrganisation(): ?string
    {
        return $this->organisation;
    }

    public function setOrganisation(?string $organisation): static
    {
        $this->organisation = $organisation;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getIdZammad(): ?int
    {
        return $this->idZammad;
    }

    public function setIdZammad(?int $idZammad): static
    {
        $this->idZammad = $idZammad;

        return $this;
    }

    public function getOrganizationId(): ?int
    {
        return $this->organizationId;
    }

    public function setOrganizationId(int $organizationId): static
    {
        $this->organizationId = $organizationId;

        return $this;
    }
}
