<?php

namespace App\Entity;

use App\Repository\TeamGameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamGameRepository::class)]
class TeamGame
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numberOfPoints = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberOfPoints(): ?int
    {
        return $this->numberOfPoints;
    }

    public function setNumberOfPoints(int $numberOfPoints): static
    {
        $this->numberOfPoints = $numberOfPoints;

        return $this;
    }
}
