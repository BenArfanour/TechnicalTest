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
     * @ORM\Column(type="integer")
     */
    private $specifcnumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $goalnumber;

    /**
     * One club has many players. This is the inverse side.
     * @ORM\OneToMany(targetEntity="App\Entity\player", mappedBy="club")
     */
    private $players;


    /**
     * Many Clubs have Many Seasons.
     * @ORM\ManyToMany(targetEntity="App\Entity\saison", inversedBy="clubs")
     * @ORM\JoinTable(name="clubs_seasons")
     */
    private $seasons;

    /**
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\images", mappedBy="clubs",cascade={"persist"})
     */
    private $images;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->seasons = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpecifcnumber(): ?int
    {
        return $this->specifcnumber;
    }

    public function setSpecifcnumber(int $specifcnumber): self
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
            $player->setClub($this);
        }

        return $this;
    }

    public function removePlayer(player $player): self
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
            // set the owning side to null (unless already changed)
            if ($player->getClub() === $this) {
                $player->setClub(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|saison[]
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }

    public function addSeason(saison $season): self
    {
        if (!$this->seasons->contains($season)) {
            $this->seasons[] = $season;
        }

        return $this;
    }

    public function removeSeason(saison $season): self
    {
        if ($this->seasons->contains($season)) {
            $this->seasons->removeElement($season);
        }

        return $this;
    }

    /**
     * @return Collection|images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setClubs($this);
        }

        return $this;
    }

    public function removeImage(images $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getClubs() === $this) {
                $image->setClubs(null);
            }
        }

        return $this;
    }

   


}
