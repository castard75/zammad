<?php

namespace App\Entity;


use ApiPlatform\Metadata\ApiResource;
use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ApiResource]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $recurrence = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ponctuel = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $technicien = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getRecurrence(): ?string
    {
        return $this->recurrence;
    }

    public function setRecurrence(?string $recurrence): static
    {
        $this->recurrence = $recurrence;

        return $this;
    }

    public function getPonctuel(): ?string
    {
        return $this->ponctuel;
    }

    public function setPonctuel(?string $ponctuel): static
    {
        $this->ponctuel = $ponctuel;

        return $this;
    }

    public function getTechnicien(): ?string
    {
        return $this->technicien;
    }

    public function setTechnicien(?string $technicien): static
    {
        $this->technicien = $technicien;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(?string $client): static
    {
        $this->client = $client;

        return $this;
    }
}
