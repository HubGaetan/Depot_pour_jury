<?php

namespace App\Entity;

use App\Repository\MenusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenusRepository::class)]
class Menus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 10, nullable: true)]
    private ?string $semaine_year = null;


    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $m1 = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $m2 = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $m3 = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $m4 = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $m5 = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $m6 = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $m7 = [];

    
    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $s1 = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $s2 = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $s3 = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $s4 = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $s5 = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $s6 = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $s7 = [];


    #[ORM\Column(nullable: true)]
    private ?bool $is_open = null;

    #[ORM\OneToMany(mappedBy: 'Menus', targetEntity: RelMenusUser::class, cascade: ['remove'])]
    private Collection $relMenusUsers;

    public function __construct()
    {
        $this->relMenusUsers = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getM1(): array
    {
        return $this->m1;
    }

    public function setM1(?array $m1): self
    {
        $this->m1 = $m1;

        return $this;
    }

    public function getM2(): array
    {
        return $this->m2;
    }

    public function setM2(?array $m2): self
    {
        $this->m2 = $m2;

        return $this;
    }

    public function getM3(): array
    {
        return $this->m3;
    }

    public function setM3(?array $m3): self
    {
        $this->m3 = $m3;

        return $this;
    }

    public function getM4(): array
    {
        return $this->m4;
    }

    public function setM4(?array $m4): self
    {
        $this->m4 = $m4;

        return $this;
    }

    
    public function getM5(): array
    {
        return $this->m5;
    }

    public function setM5(?array $m5): self
    {
        $this->m5 = $m5;

        return $this;
    }

    public function getM6(): array
    {
        return $this->m6;
    }

    public function setM6(?array $m6): self
    {
        $this->m6 = $m6;

        return $this;
    }

    public function getM7(): array
    {
        return $this->m7;
    }

    public function setM7(?array $m7): self
    {
        $this->m7 = $m7;

        return $this;
    }

    public function getS1(): array
    {
        return $this->s1;
    }

    public function setS1(?array $s1): self
    {
        $this->s1 = $s1;

        return $this;
    }

    public function getS2(): array
    {
        return $this->s2;
    }

    public function setS2(?array $s2): self
    {
        $this->s2 = $s2;

        return $this;
    }

    public function getS3(): array
    {
        return $this->s3;
    }

    public function setS3(?array $s3): self
    {
        $this->s3 = $s3;

        return $this;
    }

    public function getS4(): array
    {
        return $this->s4;
    }

    public function setS4(?array $s4): self
    {
        $this->s4 = $s4;

        return $this;
    }

    public function getS5(): array
    {
        return $this->s5;
    }

    public function setS5(?array $s5): self
    {
        $this->s5 = $s5;

        return $this;
    }

    public function getS6(): array
    {
        return $this->s6;
    }

    public function setS6(?array $s6): self
    {
        $this->s6 = $s6;

        return $this;
    }

    public function getS7(): array
    {
        return $this->s7;
    }

    public function setS7(?array $s7): self
    {
        $this->s7 = $s7;

        return $this;
    }
    public function getSemaineYear(): ?string
    {
        return $this->semaine_year;
    }

    public function setSemaineYear(?string $semaine_year): self
    {
        $this->semaine_year = $semaine_year;

        return $this;
    }

    public function isIsOpen(): ?bool
    {
        return $this->is_open;
    }

    public function setIsOpen(?bool $is_open): self
    {
        $this->is_open = $is_open;

        return $this;
    }


     
    public function toArray(): array
    {
        return [
            'M1' => $this->getM1(),
            'M2' => $this->getM2(),
            'M3' => $this->getM3(),
            'M4' => $this->getM4(),
            'M5' => $this->getM5(),
            'M6' => $this->getM6(),
            'M7' => $this->getM7(),
            'S1' => $this->getS1(),
            'S2' => $this->getS2(),
            'S3' => $this->getS3(),
            'S4' => $this->getS4(),
            'S5' => $this->getS5(),
            'S6' => $this->getS6(),
            'S7' => $this->getS7(),
      
        ];
    }

    public function __toString()
    {
        return $this->id;
    }



    // /**
    //  * Get the value of m5
    //  */ 
    // public function getM5()
    // {
    //     return $this->m5;
    // }

    // /**
    //  * Set the value of m5
    //  *
    //  * @return  self
    //  */ 
    // public function setM5($m5)
    // {
    //     $this->m5 = $m5;

    //     return $this;
    // }

    /**
     * @return Collection<int, RelMenusUser>
     */
    public function getRelMenusUsers(): Collection
    {
        return $this->relMenusUsers;
    }

    public function addRelMenusUser(RelMenusUser $relMenusUser): self
    {
        if (!$this->relMenusUsers->contains($relMenusUser)) {
            $this->relMenusUsers->add($relMenusUser);
            $relMenusUser->setMenus($this);
        }

        return $this;
    }

    public function removeRelMenusUser(RelMenusUser $relMenusUser): self
    {
        if ($this->relMenusUsers->removeElement($relMenusUser)) {
            // set the owning side to null (unless already changed)
            if ($relMenusUser->getMenus() === $this) {
                $relMenusUser->setMenus(null);
            }
        }

        return $this;
    }

}
