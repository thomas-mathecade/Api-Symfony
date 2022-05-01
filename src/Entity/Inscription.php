<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use App\Entity\Personne;
use App\Entity\Trajet;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriptionRepository::class)
 */
class Inscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Personne", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Personne $personne=null;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Trajet", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Trajet $trajet=null;

    public function __construct()
    {
        $this->personne = new ArrayCollection();
        $this->trajet = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|personne[]
     */
    public function getPersonne(): Collection
    {
        return $this->personne;
    }

    public function addPersonne(personne $personne): self
    {
        if (!$this->personne->contains($personne)) {
            $this->personne[] = $personne;
            $personne->setTrajet($this);
        }

        return $this;
    }

    public function removePersonne(personne $personne): self
    {
        if ($this->personne->removeElement($personne)) {
            // set the owning side to null (unless already changed)
            if ($personne->getTrajet() === $this) {
                $personne->setTrajet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|trajet[]
     */
    public function getTrajet(): Collection
    {
        return $this->trajet;
    }

    public function addTrajet(trajet $trajet): self
    {
        if (!$this->trajet->contains($trajet)) {
            $this->trajet[] = $trajet;
            $trajet->setInscription($this);
        }

        return $this;
    }

    public function removeTrajet(trajet $trajet): self
    {
        if ($this->trajet->removeElement($trajet)) {
            // set the owning side to null (unless already changed)
            if ($trajet->getInscription() === $this) {
                $trajet->setInscription(null);
            }
        }

        return $this;
    }
}
