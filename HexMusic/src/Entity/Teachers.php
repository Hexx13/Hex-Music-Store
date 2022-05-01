<?php

namespace App\Entity;

use App\Repository\TeachersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeachersRepository::class)]
class Teachers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $location;

    #[ORM\Column(type: 'float')]
    private $rate;

    #[ORM\OneToOne(mappedBy: 'teachers', targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $userId;

    #[ORM\OneToMany(mappedBy: 'teachers', targetEntity: Lesson::class)]
    private $lesson;

    public function __construct()
    {
        $this->lesson = new ArrayCollection();
    }

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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        // unset the owning side of the relation if necessary
        if ($userId === null && $this->userId !== null) {
            $this->userId->setTeachers(null);
        }

        // set the owning side of the relation if necessary
        if ($userId !== null && $userId->getTeachers() !== $this) {
            $userId->setTeachers($this);
        }

        $this->userId = $userId;

        return $this;
    }
    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @return Collection<int, Lesson>
     */
    public function getLesson(): Collection
    {
        return $this->lesson;
    }

    public function addLesson(Lesson $lesson): self
    {
        if (!$this->lesson->contains($lesson)) {
            $this->lesson[] = $lesson;
            $lesson->setTeachers($this);
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        if ($this->lesson->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getTeachers() === $this) {
                $lesson->setTeachers(null);
            }
        }

        return $this;
    }
}
