<?php

namespace App\Entity;

use App\Repository\CourseDBRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseDBRepository::class)]
class CourseDB
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $courceName = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $courceDes = null;

    #[ORM\Column(length: 255)]
    private ?string $courceImage = null;

    #[ORM\Column(length: 255)]
    private ?string $courceRated = null;

    #[ORM\Column(length: 255)]
    private ?string $courceAdmin = null;

    #[ORM\Column(length: 255)]
    private ?string $courceDuration = null;

    #[ORM\Column(length: 255)]
    private ?string $courceReach = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourceName(): ?string
    {
        return $this->courceName;
    }

    public function setCourceName(string $courceName): self
    {
        $this->courceName = $courceName;

        return $this;
    }

    public function getCourceDes(): ?string
    {
        return $this->courceDes;
    }

    public function setCourceDes(?string $courceDes): self
    {
        $this->courceDes = $courceDes;

        return $this;
    }

    public function getCourceImage(): ?string
    {
        return $this->courceImage;
    }

    public function setCourceImage(string $courceImage): self
    {
        $this->courceImage = $courceImage;

        return $this;
    }

    public function getCourceRated(): ?string
    {
        return $this->courceRated;
    }

    public function setCourceRated(string $courceRated): self
    {
        $this->courceRated = $courceRated;

        return $this;
    }

    public function getCourceAdmin(): ?string
    {
        return $this->courceAdmin;
    }

    public function setCourceAdmin(string $courceAdmin): self
    {
        $this->courceAdmin = $courceAdmin;

        return $this;
    }

    public function getCourceDuration(): ?string
    {
        return $this->courceDuration;
    }

    public function setCourceDuration(string $courceDuration): self
    {
        $this->courceDuration = $courceDuration;

        return $this;
    }

    public function getCourceReach(): ?string
    {
        return $this->courceReach;
    }

    public function setCourceReach(string $courceReach): self
    {
        $this->courceReach = $courceReach;

        return $this;
    }
}
