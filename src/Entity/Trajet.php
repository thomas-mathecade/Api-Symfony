<?php

namespace App\Entity;

use App\Repository\TrajetRepository;
use App\Entity\Personne;
use App\Entity\Ville;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrajetRepository::class)
 */
class Trajet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Personne", cascade={"persist"})
     */
    private Personne $personne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville", cascade={"persist"})
     * @ORM\JoinColumn(name="ville_dep_id", referencedColumnName="id")
     */
    private Ville $ville_dep;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville", cascade={"persist"})
     * @ORM\JoinColumn(name="ville_arr_id", referencedColumnName="id")
     */
    private Ville $ville_arr;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbkms;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetrajet;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Inscription", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $inscription;

    public function __construct()
    {
        $this->personne = new ArrayCollection();
        $this->inscription = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonne(): ?personne
    {
        return $this->personne;
    }

    public function setPersonne(?personne $personne): self
    {
        $this->personne = $personne;

        return $this;
    }

    public function getVilleDep(): ?ville
    {
        return $this->ville_dep;
    }

    public function setVilleDep(?ville $ville_dep): self
    {
        $this->ville_dep = $ville_dep;

        return $this;
    }

    public function getVilleArr(): ?ville
    {
        return $this->ville_arr;
    }

    public function setVilleArr(?ville $ville_arr): self
    {
        $this->ville_arr = $ville_arr;

        return $this;
    }

    public function getNbkms(): ?int
    {
        return $this->nbkms;
    }

    public function setNbkms(?int $nbkms): self
    {
        $this->nbkms = $nbkms;

        return $this;
    }

    public function getDatetrajet(): ?\DateTimeInterface
    {
        return $this->datetrajet;
    }

    public function setDatetrajet(\DateTimeInterface $datetrajet): self
    {
        $this->datetrajet = $datetrajet;

        return $this;
    }

    public function getInscription(): ?Inscription
    {
        return $this->inscription;
    }

    public function setInscription(?Inscription $inscription): self
    {
        $this->inscription = $inscription;

        return $this;
    }

    public function addPersonne(Personne $personne): self
    {
        if (!$this->personne->contains($personne)) {
            $this->personne[] = $personne;
        }

        return $this;
    }

    public function removePersonne(Personne $personne): self
    {
        $this->personne->removeElement($personne);

        return $this;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscription->contains($inscription)) {
            $this->inscription[] = $inscription;
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        $this->inscription->removeElement($inscription);

        return $this;
    }
}
