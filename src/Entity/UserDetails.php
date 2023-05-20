<?php

namespace App\Entity;

use App\Repository\UserDetailsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserDetailsRepository::class)]
class UserDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $userName = null;

    #[ORM\Column(length: 255)]
    private ?string $userFirstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $userMiddleName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $userLastName = null;

    #[ORM\Column(length: 255)]
    private ?string $userEmail = null;

    #[ORM\Column(length: 255)]
    private ?string $userMobile = null;

    #[ORM\Column(length: 255)]
    private ?string $userAge = null;

    #[ORM\Column(length: 255)]
    private ?string $userGender = null;

    #[ORM\Column(length: 255)]
    private ?string $userCity = null;

    #[ORM\Column(length: 255)]
    private ?string $userCountry = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $userImage = null;

    #[ORM\Column(length: 255)]
    private ?string $userPassword = null;

    #[ORM\Column(length: 255)]
    private ?string $userSubject = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $userInterests = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getUserFirstName(): ?string
    {
        return $this->userFirstName;
    }

    public function setUserFirstName(string $userFirstName): self
    {
        $this->userFirstName = $userFirstName;

        return $this;
    }

    public function getUserMiddleName(): ?string
    {
        return $this->userMiddleName;
    }

    public function setUserMiddleName(?string $userMiddleName): self
    {
        $this->userMiddleName = $userMiddleName;

        return $this;
    }

    public function getUserLastName(): ?string
    {
        return $this->userLastName;
    }

    public function setUserLastName(?string $userLastName): self
    {
        $this->userLastName = $userLastName;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->userEmail;
    }

    public function setUserEmail(string $userEmail): self
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    public function getUserMobile(): ?string
    {
        return $this->userMobile;
    }

    public function setUserMobile(string $userMobile): self
    {
        $this->userMobile = $userMobile;

        return $this;
    }

    public function getUserAge(): ?string
    {
        return $this->userAge;
    }

    public function setUserAge(string $userAge): self
    {
        $this->userAge = $userAge;

        return $this;
    }

    public function getUserGender(): ?string
    {
        return $this->userGender;
    }

    public function setUserGender(string $userGender): self
    {
        $this->userGender = $userGender;

        return $this;
    }

    public function getUserCity(): ?string
    {
        return $this->userCity;
    }

    public function setUserCity(string $userCity): self
    {
        $this->userCity = $userCity;

        return $this;
    }

    public function getUserCountry(): ?string
    {
        return $this->userCountry;
    }

    public function setUserCountry(string $userCountry): self
    {
        $this->userCountry = $userCountry;

        return $this;
    }

    public function getUserImage(): ?string
    {
        return $this->userImage;
    }

    public function setUserImage(?string $userImage): self
    {
        $this->userImage = $userImage;

        return $this;
    }

    public function getUserPassword(): ?string
    {
        return $this->userPassword;
    }

    public function setUserPassword(string $userPassword): self
    {
        $this->userPassword = $userPassword;

        return $this;
    }

    public function getUserSubject(): ?string
    {
        return $this->userSubject;
    }

    public function setUserSubject(string $userSubject): self
    {
        $this->userSubject = $userSubject;

        return $this;
    }

    public function getUserInterests(): array
    {
        return $this->userInterests;
    }

    public function setUserInterests(array $userInterests): self
    {
        $this->userInterests = $userInterests;

        return $this;
    }
}
