<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userOrig = null;

    #[ORM\ManyToOne(inversedBy: 'messagesRecus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userDest = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getUserOrig(): ?User
    {
        return $this->userOrig;
    }

    public function setUserOrig(?User $userOrig): static
    {
        $this->userOrig = $userOrig;

        return $this;
    }

    public function getUserDest(): ?User
    {
        return $this->userDest;
    }

    public function setUserDest(?User $userDest): static
    {
        $this->userDest = $userDest;

        return $this;
    }
}
