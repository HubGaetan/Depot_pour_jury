<?php

namespace App\Entity;

use App\Repository\RelMenusUserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RelMenusUserRepository::class)]
class RelMenusUser
{
    
    // #[ORM\GeneratedValue]
    // #[ORM\Column]
    // private ?int $id = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'relMenusUsers')]
    private ?User $User = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'relMenusUsers')]
    private ?Menus $Menus = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $inscription = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getMenus(): ?Menus
    {
        return $this->Menus;
    }

    public function setMenus(?Menus $Menus): self
    {
        $this->Menus = $Menus;

        return $this;
    }

    public function getInscription(): array
    {
        return $this->inscription;
    }

    public function setInscription(?array $inscription): self
    {
        $this->inscription = $inscription;

        return $this;
    }
}
