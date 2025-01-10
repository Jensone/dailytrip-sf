<?php

namespace App\Entity;

use App\Repository\PoiRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PoiRepository::class)]
class Poi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $point = null;

    #[ORM\ManyToOne(inversedBy: 'pois')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Localisation $location = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Gallery $gallery = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoint(): ?string
    {
        return $this->point;
    }

    public function setPoint(string $point): static
    {
        $this->point = $point;

        return $this;
    }

    public function getLocation(): ?Localisation
    {
        return $this->location;
    }

    public function setLocation(?Localisation $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getGallery(): ?Gallery
    {
        return $this->gallery;
    }

    public function setGallery(?Gallery $gallery): static
    {
        $this->gallery = $gallery;

        return $this;
    }
}
