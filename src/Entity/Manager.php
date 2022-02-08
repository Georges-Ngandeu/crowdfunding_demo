<?php

namespace App\Entity;

use App\Repository\ManagerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ManagerRepository::class)
 */
class Manager
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $manager_createdat;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=SubscriberProject::class, mappedBy="manager_id")
     */
    private $manager_subscription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $manager_firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $manager_lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $manager_region;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $manager_phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $manager_username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $manager_email;

     /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $manager_count_subscription = 0;

    public function __construct()
    {
        $this->manager_subscription = new ArrayCollection();
        $this->manager_createdat = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManagerCreatedat(): ?\DateTimeInterface
    {
        return $this->manager_createdat;
    }

    public function setManagerCreatedat(\DateTimeInterface $manager_createdat): self
    {
        $this->manager_createdat = $manager_createdat;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|SubscriberProject[]
     */
    public function getManagerSubscription(): Collection
    {
        return $this->manager_subscription;
    }

    public function addManagerSubscription(SubscriberProject $managerSubscription): self
    {
        if (!$this->manager_subscription->contains($managerSubscription)) {
            $this->manager_subscription[] = $managerSubscription;
            $managerSubscription->setManagerId($this);
        }

        return $this;
    }

    public function removeManagerSubscription(SubscriberProject $managerSubscription): self
    {
        if ($this->manager_subscription->contains($managerSubscription)) {
            $this->manager_subscription->removeElement($managerSubscription);
            // set the owning side to null (unless already changed)
            if ($managerSubscription->getManagerId() === $this) {
                $managerSubscription->setManagerId(null);
            }
        }

        return $this;
    }

    public function getManagerFirstname(): ?string
    {
        return $this->manager_firstname;
    }

    public function setManagerFirstname(?string $manager_firstname): self
    {
        $this->manager_firstname = $manager_firstname;

        return $this;
    }

    public function getManagerLastname(): ?string
    {
        return $this->manager_lastname;
    }

    public function setManagerLastname(?string $manager_lastname): self
    {
        $this->manager_lastname = $manager_lastname;

        return $this;
    }

    public function getManagerRegion(): ?string
    {
        return $this->manager_region;
    }

    public function setManagerRegion(?string $manager_region): self
    {
        $this->manager_region = $manager_region;

        return $this;
    }

    public function getManagerPhone(): ?string
    {
        return $this->manager_phone;
    }

    public function setManagerPhone(?string $manager_phone): self
    {
        $this->manager_phone = $manager_phone;

        return $this;
    }

    public function getManagerUsername(): ?string
    {
        return $this->manager_username;
    }

    public function setManagerUsername(?string $manager_username): self
    {
        $this->manager_username = $manager_username;

        return $this;
    }

    public function getManagerEmail(): ?string
    {
        return $this->manager_email;
    }

    public function setManagerEmail(?string $manager_email): self
    {
        $this->manager_email = $manager_email;

        return $this;
    }

    /**
     * Get the value of manager_count_subscription
     */ 
    public function getManagerCountSubscription()
    {
        return $this->manager_count_subscription;
    }

    /**
     * Set the value of manager_count_subscription
     *
     * @return  self
     */ 
    public function setManagerCountSubscription($manager_count_subscription)
    {
        $this->manager_count_subscription = $manager_count_subscription;

        return $this;
    }
}
