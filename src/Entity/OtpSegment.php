<?php

namespace App\Entity;

use App\Repository\OtpSegmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OtpSegmentRepository::class)
 */
class OtpSegment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sms;

    /**
     * @ORM\Column(type="boolean")
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=OtpLine::class, mappedBy="segment")
     */
    private $otpLines;

    /**
     * @ORM\Column(type="integer")
     */
    private $size;

    public function __construct()
    {
        $this->otpLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
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

    public function getSms(): ?bool
    {
        return $this->sms;
    }

    public function setSms(bool $sms): self
    {
        $this->sms = $sms;

        return $this;
    }

    public function getEmail(): ?bool
    {
        return $this->email;
    }

    public function setEmail(bool $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|OtpLine[]
     */
    public function getOtpLines(): Collection
    {
        return $this->otpLines;
    }

    public function addOtpLine(OtpLine $otpLine): self
    {
        if (!$this->otpLines->contains($otpLine)) {
            $this->otpLines[] = $otpLine;
            $otpLine->setSegment($this);
        }

        return $this;
    }

    public function removeOtpLine(OtpLine $otpLine): self
    {
        if ($this->otpLines->contains($otpLine)) {
            $this->otpLines->removeElement($otpLine);
            // set the owning side to null (unless already changed)
            if ($otpLine->getSegment() === $this) {
                $otpLine->setSegment(null);
            }
        }

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }
}