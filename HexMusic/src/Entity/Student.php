<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $instrument;

    #[ORM\OneToOne(mappedBy: 'student', targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $username;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getInstrument(): ?string
    {
        return $this->instrument;
    }

    public function setInstrument(?string $instrument): self
    {
        $this->instrument = $instrument;

        return $this;
    }

    public function getUsername(): ?User
    {
        return $this->username;
    }

    public function setUsername(?User $username): self
    {
        // unset the owning side of the relation if necessary
        if ($username === null && $this->username !== null) {
            $this->username->setStudent(null);
        }

        // set the owning side of the relation if necessary
        if ($username !== null && $username->getStudent() !== $this) {
            $username->setStudent($this);
        }

        $this->username = $username;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
