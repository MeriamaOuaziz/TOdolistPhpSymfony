<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name = '';

    #[ORM\Column(length: 255)]
    private string $assignedTo = '';

    #[ORM\Column(length: 10)]
    private string $importance = 'Bas'; // Bas | Moyen | Haut

    public function getId(): ?int { return $this->id; }

    public function getName(): string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }

    public function getAssignedTo(): string { return $this->assignedTo; }
    public function setAssignedTo(string $assignedTo): self { $this->assignedTo = $assignedTo; return $this; }

    public function getImportance(): string { return $this->importance; }
    public function setImportance(string $importance): self { $this->importance = $importance; return $this; }
}
