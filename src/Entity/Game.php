<?php

namespace App\Entity;

use App\Repository\GameRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\GreaterThanOrEqual('today')]
    private ?DateTimeImmutable $startingDate = null;

    #[ORM\Column(nullable: true)]
    #[Assert\GreaterThanOrEqual('today')]
    private ?DateTimeImmutable $endingDate = null;

    #[ORM\Column(nullable: true)]
    private ?string $winnerID = null;

    #[ORM\Column]
    private string $firstTeam;

    #[ORM\Column]
    #[Assert\NotEqualTo(propertyPath: 'firstTeam')]
    private string $secondTeam;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartingDate(): ?DateTimeImmutable
    {
        return $this->startingDate;
    }

    public function setStartingDate(?DateTimeImmutable $startingDate): static
    {
        $this->startingDate = $startingDate;

        return $this;
    }


    public function getEndingDate(): ?DateTimeImmutable
    {
        return $this->endingDate;
    }

    public function setEndingDate(?DateTimeImmutable $endingDate = null): static
    {
        $this->endingDate = $endingDate;

        return $this;
    }

    public function getWinnerID(): ?string
    {
        return $this->winnerID;
    }

    public function setWinnerID(?string $winnerID): static
    {
        $this->winnerID = $winnerID;

        return $this;
    }

    public function getFirstTeam(): string
    {
        return $this->firstTeam;
    }

    public function setFirstTeam(string $firstTeam): static
    {
        $this->firstTeam = $firstTeam;

        return $this;
    }

    public function getSecondTeam(): string
    {
        return $this->secondTeam;
    }

    public function setSecondTeam(string $secondTeam): static
    {
        $this->secondTeam = $secondTeam;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getWinnerID();
    }
}
