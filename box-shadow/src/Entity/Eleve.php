<?php

namespace App\Entity;

use App\Repository\EleveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: EleveRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Eleve implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = ["ROLE_ELEVE"];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'id_eleve', targetEntity: Suivre::class)]
    private Collection $suivres;

    #[ORM\OneToMany(mappedBy: 'id_eleve', targetEntity: Suivre::class)]
    private Collection $suivres2;

    public function __construct()
    {
        $this->suivres = new ArrayCollection();
        $this->suivres2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
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

    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Suivre>
     */
    public function getSuivres(): Collection
    {
        return $this->suivres;
    }

    public function addSuivre(Suivre $suivre): static
    {
        if (!$this->suivres->contains($suivre)) {
            $this->suivres->add($suivre);
            $suivre->setIdEleve($this);
        }

        return $this;
    }

    public function removeSuivre(Suivre $suivre): static
    {
        if ($this->suivres->removeElement($suivre)) {
            // set the owning side to null (unless already changed)
            if ($suivre->getIdEleve() === $this) {
                $suivre->setIdEleve(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Suivre>
     */
    public function getSuivres2(): Collection
    {
        return $this->suivres2;
    }

    public function addSuivres2(Suivre $suivres2): static
    {
        if (!$this->suivres2->contains($suivres2)) {
            $this->suivres2->add($suivres2);
            $suivres2->setIdEleve($this);
        }

        return $this;
    }

    public function removeSuivres2(Suivre $suivres2): static
    {
        if ($this->suivres2->removeElement($suivres2)) {
            // set the owning side to null (unless already changed)
            if ($suivres2->getIdEleve() === $this) {
                $suivres2->setIdEleve(null);
            }
        }

        return $this;
    }
}
