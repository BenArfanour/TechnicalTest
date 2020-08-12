<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=ClubRepository::class)
 */
class club
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $specifcnumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $goalnumber;


    /**
     * Many Clubs have Many Players.
     * @ORM\ManyToMany(targetEntity="App\Entity\player", mappedBy="clubs")
     */
    private $players;


    /**
     * Many seasons have one club. This is the owning side.
     * @ORM\ManyToOne(targetEntity="App\Entity\saison", inversedBy="clubs")
     * @ORM\JoinColumn(name="saison_id", referencedColumnName="id")
     */
    private $season;

    /**
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\images", inversedBy="clubs")
     */
    private $images;

    public function __construct()
    {
        $this->players = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpecifcnumber()
    {
        return $this->specifcnumber;
    }

    public function setSpecifcnumber(string $specifcnumber): self
    {
        $this->specifcnumber = $specifcnumber;
        return $this;
    }

    public function getGoalnumber(): ?int
    {
        return $this->goalnumber;
    }

    public function setGoalnumber(int $goalnumber): self
    {
        $this->goalnumber = $goalnumber;
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

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated): void
    {
        $this->updated = $updated;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created): void
    {
        $this->created = $created;
    }


    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $this->setUpdated(new \DateTime('now'));
        if ($this->getCreated() === null) {
            $this->setCreated(new \DateTime('now'));
        }
    }

    /**
     * @return Collection|player[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->addClub($this);
        }

        return $this;
    }

    public function removePlayer(player $player): self
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
            $player->removeClub($this);
        }

        return $this;
    }

    public function getSeason(): ?saison
    {
        return $this->season;
    }

    public function setSeason(?saison $season): self
    {
        $this->season = $season;

        return $this;
    }

    public function getImages(): ?images
    {
        return $this->images;
    }

    public function setImages(?images $images): self
    {
        $this->images = $images;

        return $this;
    }



}
