<?php

namespace App\Entity;

use App\Repository\StarsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StarsRepository::class)]
class Stars
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    public ?string $idIMDB = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_url = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $birthplace = null;

    #[ORM\Column(nullable: true)]
    private ?float $height = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $biography = null;

    #[ORM\Column(length: 20)]
    private ?string $Birthday = null;

    #[ORM\Column(nullable: true)]
    public ?int $MD = null;

    #[ORM\Column(nullable: true)]
    private ?int $Year = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getIdIMDB(): ?string
    {
        return $this->idIMDB;
    }

    public function setIdIMDB(string $idIMDB): self
    {
        $this->idIMDB = $idIMDB;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(?string $image_url): self
    {
        $this->image_url = $image_url;

        return $this;
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


    public function getBirthplace(): ?string
    {
        return $this->birthplace;
    }

    public function setBirthplace(?string $birthplace): self
    {
        $this->birthplace = $birthplace;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(?float $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): self
    {
        $this->biography = $biography;

        return $this;
    }

    public function getBirthday(): ?string
    {
        return $this->Birthday;
    }

    public function setBirthday(string $Birthday): self
    {
        $this->Birthday = $Birthday;

        return $this;
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

    public function getYear(): ?int
    {
        return $this->Year;
    }

    public function setYear(?int $Year): self
    {
        $this->Year = $Year;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
