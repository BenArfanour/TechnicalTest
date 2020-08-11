<?php

namespace App\Entity;

use App\Repository\SaisonRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=SaisonRepository::class)
 */
class saison
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startdate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $enddate;

    /**
     * Many Seasons have Many Clubs.
     * @ORM\ManyToMany(targetEntity="App\Entity\club", mappedBy="seasons")
     */
    private $clubs;

    public function __construct()
    {
        $this->clubs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartdate(): ?\DateTimeInterface
    {
        return $this->startdate;
    }

    public function setStartdate(\DateTimeInterface $startdate): self
    {
        $this->startdate = $startdate;
        return $this;
    }

    public function getEnddate(): ?\DateTimeInterface
    {
        return $this->enddate;
    }

    public function setEnddate(\DateTimeInterface $enddate): self
    {
        $this->enddate = $enddate;
        return $this;
    }

    /**
     * @return Collection|club[]
     */
    public function getClubs(): Collection
    {
        return $this->clubs;
    }

    public function addClub(club $club): self
    {
        if (!$this->clubs->contains($club)) {
            $this->clubs[] = $club;
            $club->addSeason($this);
        }

        return $this;
    }

    public function removeClub(club $club): self
    {
        if ($this->clubs->contains($club)) {
            $this->clubs->removeElement($club);
            $club->removeSeason($this);
        }

        return $this;
    }

   
}
