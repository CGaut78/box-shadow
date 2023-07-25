<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
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
}
