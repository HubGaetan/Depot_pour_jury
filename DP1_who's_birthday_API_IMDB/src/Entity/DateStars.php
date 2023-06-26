<?php

namespace App\Entity;

use App\Repository\DateStarsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DateStarsRepository::class)]
class DateStars
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $MD = null;

    #[ORM\Column(length: 20, nullable: true)]
    public ?string $IdIMDB = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMD(): ?int
    {
        return $this->MD;
    }

    public function setMD(?int $MD): self
    {
        $this->MD = $MD;

        return $this;
    }

    public function getIdIMDB(): ?string
    {
        return $this->IdIMDB;
    }

    public function setIdIMDB(?string $IdIMDB): self
    {
        $this->IdIMDB = $IdIMDB;

        return $this;
    }
}
