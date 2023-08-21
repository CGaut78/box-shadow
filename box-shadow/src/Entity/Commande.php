<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Formation $id_formation = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Formateur $id_formateur = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\OneToMany(mappedBy: 'id_commande', targetEntity: Suivre::class)]
    private Collection $suivres;

    public function __construct()
    {
        $this->suivres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdFormation(): ?Formation
    {
        return $this->id_formation;
    }

    public function setIdFormation(?Formation $id_formation): static
    {
        $this->id_formation = $id_formation;

        return $this;
    }

    public function getIdFormateur(): ?Formateur
    {
        return $this->id_formateur;
    }

    public function setIdFormateur(?Formateur $id_formateur): static
    {
        $this->id_formateur = $id_formateur;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

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
            $suivre->setIdCommande($this);
        }

        return $this;
    }

    public function removeSuivre(Suivre $suivre): static
    {
        if ($this->suivres->removeElement($suivre)) {
            // set the owning side to null (unless already changed)
            if ($suivre->getIdCommande() === $this) {
                $suivre->setIdCommande(null);
            }
        }

        return $this;
    }
}
