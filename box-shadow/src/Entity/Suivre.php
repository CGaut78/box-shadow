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
    #[ORM\JoinColumn(nullable: false)]
    private ?Formation $id_formation = null;

    #[ORM\ManyToOne(inversedBy: 'suivres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Eleve $id_eleve = null;

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
