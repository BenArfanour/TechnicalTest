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
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startdate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $enddate;

    /**
     * One club has many season. This is the inverse side.
     * @ORM\OneToMany(targetEntity="App\Entity\club", mappedBy="season")
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

    public function getStartdate()
    {
        return $this->startdate;
    }

    public function setStartdate(\DateTime $startdate): self
    {
        $this->startdate = $startdate;
        return $this;
    }

    public function getEnddate()
    {
        return $this->enddate;
    }

    public function setEnddate(\DateTime $enddate): self
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
            $club->setSeason($this);
        }

        return $this;
    }

    public function removeClub(club $club): self
    {
        if ($this->clubs->contains($club)) {
            $this->clubs->removeElement($club);
            // set the owning side to null (unless already changed)
            if ($club->getSeason() === $this) {
                $club->setSeason(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }


    

   
}
