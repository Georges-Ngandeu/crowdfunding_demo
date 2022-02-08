<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 * @ORM\Table(name="`admin`")
 */
class Admin
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
    private $admin_createdat;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $admin_firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $admin_lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $admin_region;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $admin_phone;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="admin_id")
     */
    private $admin_project;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $admin_email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $admin_username;

    public function __construct()
    {
        $this->admin_project = new ArrayCollection();
        $this->admin_createdat = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdminCreatedat(): ?\DateTimeInterface
    {
        return $this->admin_createdat;
    }

    public function setAdminCreatedat(\DateTimeInterface $admin_createdat): self
    {
        $this->admin_createdat = $admin_createdat;

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

    public function getAdminFirstname(): ?string
    {
        return $this->admin_firstname;
    }

    public function setAdminFirstname(?string $admin_firstname): self
    {
        $this->admin_firstname = $admin_firstname;

        return $this;
    }

    public function getAdminLastname(): ?string
    {
        return $this->admin_lastname;
    }

    public function setAdminLastname(?string $admin_lastname): self
    {
        $this->admin_lastname = $admin_lastname;

        return $this;
    }

    public function getAdminRegion(): ?string
    {
        return $this->admin_region;
    }

    public function setAdminRegion(?string $admin_region): self
    {
        $this->admin_region = $admin_region;

        return $this;
    }

    public function getAdminPhone(): ?string
    {
        return $this->admin_phone;
    }

    public function setAdminPhone(?string $admin_phone): self
    {
        $this->admin_phone = $admin_phone;

        return $this;
    }

    public function getAdminEmail(): ?string
    {
        return $this->admin_email;
    }

    public function setAdminEmail(?string $admin_email): self
    {
        $this->admin_email = $admin_email;

        return $this;
    }

    public function getAdminUsername(): ?string
    {
        return $this->admin_username;
    }

    public function setAdminUsername(?string $admin_username): self
    {
        $this->admin_username = $admin_username;

        return $this;
    }
}
