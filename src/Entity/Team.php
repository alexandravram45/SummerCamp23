<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use function Symfony\Component\Translation\t;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'Name must be at least {{ limit }} characters long',
        maxMessage: 'Name cannot be longer than {{ limit }} characters',
    )]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\GreaterThanOrEqual(1, message: "This number must be greater than 0!")]
    private int $numberOfPlayers;

    #[ORM\Column(nullable: true)]
    #[Assert\Image(
        maxSize: '2048k',
        mimeTypes: ['image/png', 'image/jpeg'],
        maxSizeMessage: 'The image is too large.',
        mimeTypesMessage: 'This file must be .png or .jpeg!'
    )]
    private ?string $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getNumberOfPlayers(): ?int
    {
        return $this->numberOfPlayers;
    }

    public function setNumberOfPlayers(int $numberOfPlayers): static
    {
        $this->numberOfPlayers = $numberOfPlayers;

        return $this;
    }

    public function getImage(): ?string
    {

        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }



    public function __toString(): string
    {
        return $this->getName();
    }


}
