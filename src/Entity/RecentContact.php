<?php

namespace App\Entity;

use App\Repository\RecentContactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecentContactRepository::class)
 */
class RecentContact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ip;

    /**
     * @ORM\Column(type="integer")
     */
    private $sent_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getSentAt(): ?int
    {
        return $this->sent_at;
    }

    public function setSentAt(int $sent_at): self
    {
        $this->sent_at = $sent_at;

        return $this;
    }

    public function setSentAtFromDate(\DateTimeInterface $sent_at): self
    {
        $this->sent_at = $sent_at->getTimestamp();

        return $this;
    }

    public function getSentAtAsDate(): ?\DateTimeInterface
    {
        $sent_at = new DateTime();
        $sent_at->setTimestamp($this->sent_at);
        return $sent_at;
    }
}
