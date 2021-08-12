<?php

namespace App\Entity;

use App\Repository\ListeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListeRepository::class)
 */
class Liste
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\OneToMany(targetEntity=Tache::class, mappedBy="Liste")
     */
    private $Tache;

    public function __construct()
    {
        $this->Tache = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    /**
     * @return Collection|Tache[]
     */
    public function getTache(): Collection
    {
        return $this->Tache;
    }

    public function addTache(Tache $tache): self
    {
        if (!$this->Tache->contains($tache)) {
            $this->Tache[] = $tache;
            $tache->setListe($this);
        }

        return $this;
    }

    public function removeTache(Tache $tache): self
    {
        if ($this->Tache->removeElement($tache)) {
            // set the owning side to null (unless already changed)
            if ($tache->getListe() === $this) {
                $tache->setListe(null);
            }
        }

        return $this;
    }
}
