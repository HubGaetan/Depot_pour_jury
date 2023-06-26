<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $status = null;

    // #[ORM\Column(type: Types::ARRAY, nullable: true)]
    // private array $regime = [];

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: RelMenusUser::class, cascade: ['remove'])]
    private Collection $relMenusUsers;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $formation = null;

    #[ORM\Column]
    private array $allergies = [];

    #[ORM\Column]
    private array $adresse_postale = [];

    #[ORM\Column(nullable: true)]
    private ?bool $vegan = null;

    #[ORM\Column(nullable: true)]
    private ?bool $porc = null;

    public function __construct()
    {
        $this->relMenusUsers = new ArrayCollection();
        $this->allergies = [];
        $this->adresse_postale = array();
        $this->roles = ["ROLE_USER"];
        $this->status = 'Ext';
    }


    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    // public function getRegime(): array
    // {
    //     return $this->regime;
    // }

    // public function setRegime(?array $regime): self
    // {
    //     $this->regime = $regime;

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
            $relMenusUser->setUser($this);
        }

        return $this;
    }

    public function removeRelMenusUser(RelMenusUser $relMenusUser): self
    {
        if ($this->relMenusUsers->removeElement($relMenusUser)) {
            // set the owning side to null (unless already changed)
            if ($relMenusUser->getUser() === $this) {
                $relMenusUser->setUser(null);
            }
        }

        return $this;
    }

    public function getFormation(): ?string
    {
        return $this->formation;
    }

    public function setFormation(?string $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    public function getAllergies(): array
    {
        return $this->allergies;
    }

    public function setAllergies(?array $allergies): self
    {
        $this->allergies = $allergies;

        return $this;
    }

    public function getAdressePostale(): array
    {
        return $this->adresse_postale;
    }

    public function setAdressePostale(?array $adresse_postale): self
    {
        $this->adresse_postale = $adresse_postale;

        return $this;
    }

    public function isVegan(): ?bool
    {
        return $this->vegan;
    }

    public function setVegan(?bool $vegan): self
    {
        $this->vegan = $vegan;

        return $this;
    }

    public function isPorc(): ?bool
    {
        return $this->porc;
    }

    public function setPorc(?bool $porc): self
    {
        $this->porc = $porc;

        return $this;
    }

}