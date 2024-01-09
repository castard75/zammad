<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $zammadId = null;

    #[ORM\Column(nullable: true)]
    private ?int $organizationId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $login = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $roles = null;

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

    public function getZammadId(): ?int
    {
        return $this->zammadId;
    }

    public function setZammadId(?int $zammadId): static
    {
        $this->zammadId = $zammadId;

        return $this;
    }

    public function getOrganizationId(): ?int
    {
        return $this->organizationId;
    }

    public function setOrganizationId(?int $organizationId): static
    {
        $this->organizationId = $organizationId;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): static
    {
        $this->login = $login;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): ?string
    {
        return $this->roles;
    }

    public function setRoles(?string $roles): static
    {
        $this->roles = $roles;

        return $this;
    }
}
