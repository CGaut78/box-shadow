<?php

namespace App\Entity;

use App\Repository\SuivreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuivreRepository::class)]
class Suivre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'suivres')]
    private ?Commande $id_commande = null;

    #[ORM\ManyToOne(inversedBy: 'suivres2')]
    private ?Eleve $id_eleve = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCommande(): ?Commande
    {
        return $this->id_commande;
    }

    public function setIdCommande(?Commande $id_commande): static
    {
        $this->id_commande = $id_commande;

        return $this;
    }

    public function getIdEleve(): ?Eleve
    {
        return $this->id_eleve;
    }

    public function setIdEleve(?Eleve $id_eleve): static
    {
        $this->id_eleve = $id_eleve;

        return $this;
    }
}
