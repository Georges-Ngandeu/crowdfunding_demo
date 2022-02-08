<?php

namespace App\Entity;

use App\Repository\SubscriberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubscriberRepository::class)
 */
class Subscriber
{
    const SERVER_PATH_TO_IMAGE_FOLDER = 'companies_documents';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $subscriber_createdat;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=SubscriberProject::class, mappedBy="subscriber_id")
     */
    private $subscriber_project;
    

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_enterprise_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_director_firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_director_lastname;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $subscriber_birthdate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_birth_place;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_identity_card_number;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $subscriber_identity_card_delivery_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_identity_card_delivery_place;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_profession;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_town;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_marital_status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_professional_status;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $subscriber_revenu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_revenu_origine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_language;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_civility;

    /**
     * Unmapped property to handle image uploads
     */
    private $imagefile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_username;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $subscriber_moraleperson = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_nationality;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_other_telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_other_revenu_origin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscriber_region;

    /**
     * @return mixed
     */
    public function getImagefile()
    {
        return $this->imagefile;
    }

    /**
     * @param mixed $imagefile
     */
    public function setImagefile($imagefile)
    {
        $this->imagefile = $imagefile;
    }

    public function __construct()
    {
        $this->subscriber_project = new ArrayCollection();
        $this->subscriber_createdat = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubscriberCreatedat(): ?\DateTimeInterface
    {
        return $this->subscriber_createdat;
    }

    public function setSubscriberCreatedat(\DateTimeInterface $subscriber_createdat): self
    {
        $this->subscriber_createdat = $subscriber_createdat;

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
    public function getSubscriberProject(): Collection
    {
        return $this->subscriber_project;
    }

    public function addSubscriberProject(SubscriberProject $subscriberProject): self
    {
        if (!$this->subscriber_project->contains($subscriberProject)) {
            $this->subscriber_project[] = $subscriberProject;
            $subscriberProject->setSubscriberId($this);
        }

        return $this;
    }

    public function removeSubscriberProject(SubscriberProject $subscriberProject): self
    {
        if ($this->subscriber_project->contains($subscriberProject)) {
            $this->subscriber_project->removeElement($subscriberProject);
            // set the owning side to null (unless already changed)
            if ($subscriberProject->getSubscriberId() === $this) {
                $subscriberProject->setSubscriberId(null);
            }
        }

        return $this;
    }

    public function getSubscriberFirstname(): ?string
    {
        return $this->subscriber_firstname;
    }

    public function setSubscriberFirstname(?string $subscriber_firstname): self
    {
        $this->subscriber_firstname = $subscriber_firstname;

        return $this;
    }

    public function getSubscriberLastname(): ?string
    {
        return $this->subscriber_lastname;
    }

    public function setSubscriberLastname(?string $subscriber_lastname): self
    {
        $this->subscriber_lastname = $subscriber_lastname;

        return $this;
    }

    public function getSubscriberEnterpriseName(): ?string
    {
        return $this->subscriber_enterprise_name;
    }

    public function setSubscriberEnterpriseName(?string $subscriber_enterprise_name): self
    {
        $this->subscriber_enterprise_name = $subscriber_enterprise_name;

        return $this;
    }

    public function getSubscriberDirectorFirstname(): ?string
    {
        return $this->subscriber_director_firstname;
    }

    public function setSubscriberDirectorFirstname(?string $subscriber_director_firstname): self
    {
        $this->subscriber_director_firstname = $subscriber_director_firstname;

        return $this;
    }

    public function getSubscriberDirectorLastname(): ?string
    {
        return $this->subscriber_director_lastname;
    }

    public function setSubscriberDirectorLastname(?string $subscriber_director_lastname): self
    {
        $this->subscriber_director_lastname = $subscriber_director_lastname;

        return $this;
    }

    public function getSubscriberBirthdate(): ?\DateTimeInterface
    {
        return $this->subscriber_birthdate;
    }

    public function setSubscriberBirthdate(?\DateTimeInterface $subscriber_birthdate): self
    {
        $this->subscriber_birthdate = $subscriber_birthdate;

        return $this;
    }

    public function getSubscriberBirthPlace(): ?string
    {
        return $this->subscriber_birth_place;
    }

    public function setSubscriberBirthPlace(?string $subscriber_birth_place): self
    {
        $this->subscriber_birth_place = $subscriber_birth_place;

        return $this;
    }

    public function getSubscriberIdentityCardNumber(): ?string
    {
        return $this->subscriber_identity_card_number;
    }

    public function setSubscriberIdentityCardNumber(?string $subscriber_identity_card_number): self
    {
        $this->subscriber_identity_card_number = $subscriber_identity_card_number;

        return $this;
    }

    public function getSubscriberIdentityCardDeliveryDate(): ?\DateTimeInterface
    {
        return $this->subscriber_identity_card_delivery_date;
    }

    public function setSubscriberIdentityCardDeliveryDate(?\DateTimeInterface $subscriber_identity_card_delivery_date): self
    {
        $this->subscriber_identity_card_delivery_date = $subscriber_identity_card_delivery_date;

        return $this;
    }

    public function getSubscriberIdentityCardDeliveryPlace(): ?string
    {
        return $this->subscriber_identity_card_delivery_place;
    }

    public function setSubscriberIdentityCardDeliveryPlace(?string $subscriber_identity_card_delivery_place): self
    {
        $this->subscriber_identity_card_delivery_place = $subscriber_identity_card_delivery_place;

        return $this;
    }

    public function getSubscriberTelephone(): ?string
    {
        return $this->subscriber_telephone;
    }

    public function setSubscriberTelephone(?string $subscriber_telephone): self
    {
        $this->subscriber_telephone = $subscriber_telephone;

        return $this;
    }

    public function getSubscriberProfession(): ?string
    {
        return $this->subscriber_profession;
    }

    public function setSubscriberProfession(?string $subscriber_profession): self
    {
        $this->subscriber_profession = $subscriber_profession;

        return $this;
    }

    public function getSubscriberTown(): ?string
    {
        return $this->subscriber_town;
    }

    public function setSubscriberTown(?string $subscriber_town): self
    {
        $this->subscriber_town = $subscriber_town;

        return $this;
    }

    public function getSubscriberMaritalStatus(): ?string
    {
        return $this->subscriber_marital_status;
    }

    public function setSubscriberMaritalStatus(?string $subscriber_marital_status): self
    {
        $this->subscriber_marital_status = $subscriber_marital_status;

        return $this;
    }

    public function getSubscriberProfessionalStatus(): ?string
    {
        return $this->subscriber_professional_status;
    }

    public function setSubscriberProfessionalStatus(?string $subscriber_professional_status): self
    {
        $this->subscriber_professional_status = $subscriber_professional_status;

        return $this;
    }

    public function getSubscriberRevenu(): ?float
    {
        return $this->subscriber_revenu;
    }

    public function setSubscriberRevenu(?float $subscriber_revenu): self
    {
        $this->subscriber_revenu = $subscriber_revenu;

        return $this;
    }

    public function getSubscriberRevenuOrigine(): ?string
    {
        return $this->subscriber_revenu_origine;
    }

    public function setSubscriberRevenuOrigine(?string $subscriber_revenu_origine): self
    {
        $this->subscriber_revenu_origine = $subscriber_revenu_origine;

        return $this;
    }

    public function getSubscriberImage(): ?string
    {
        return $this->subscriber_image;
    }

    public function setSubscriberImage(?string $subscriber_image): self
    {
        $this->subscriber_image = $subscriber_image;

        return $this;
    }

    public function getSubscriberLanguage(): ?string
    {
        return $this->subscriber_language;
    }

    public function setSubscriberLanguage(?string $subscriber_language): self
    {
        $this->subscriber_language = $subscriber_language;

        return $this;
    }

    public function getSubscriberCivility(): ?string
    {
        return $this->subscriber_civility;
    }

    public function setSubscriberCivility(?string $subscriber_civility): self
    {
        $this->subscriber_civility = $subscriber_civility;

        return $this;
    }

    public function getSubscriberEmail(): ?string
    {
        return $this->subscriber_email;
    }

    public function setSubscriberEmail(?string $subscriber_email): self
    {
        $this->subscriber_email = $subscriber_email;

        return $this;
    }

    public function getSubscriberUsername(): ?string
    {
        return $this->subscriber_username;
    }

    public function setSubscriberUsername(?string $subscriber_username): self
    {
        $this->subscriber_username = $subscriber_username;

        return $this;
    }

    public function getSubscriberMoraleperson(): ?array
    {
        return $this->subscriber_moraleperson;
    }

    public function setSubscriberMoraleperson(?array $subscriber_moraleperson): self
    {
        $this->subscriber_moraleperson = $subscriber_moraleperson;

        return $this;
    }

    public function getSubscriberGender(): ?string
    {
        return $this->subscriber_gender;
    }

    public function setSubscriberGender(?string $subscriber_gender): self
    {
        $this->subscriber_gender = $subscriber_gender;

        return $this;
    }

    public function getSubscriberNationality(): ?string
    {
        return $this->subscriber_nationality;
    }

    public function setSubscriberNationality(?string $subscriber_nationality): self
    {
        $this->subscriber_nationality = $subscriber_nationality;

        return $this;
    }

    public function getSubscriberOtherTelephone(): ?string
    {
        return $this->subscriber_other_telephone;
    }

    public function setSubscriberOtherTelephone(string $subscriber_other_telephone): self
    {
        $this->subscriber_other_telephone = $subscriber_other_telephone;

        return $this;
    }

    public function getSubscriberOtherRevenuOrigin(): ?string
    {
        return $this->subscriber_other_revenu_origin;
    }

    public function setSubscriberOtherRevenuOrigin(?string $subscriber_other_revenu_origin): self
    {
        $this->subscriber_other_revenu_origin = $subscriber_other_revenu_origin;

        return $this;
    }

    public function getSubscriberCountry(): ?string
    {
        return $this->subscriber_country;
    }

    public function setSubscriberCountry(?string $subscriber_country): self
    {
        $this->subscriber_country = $subscriber_country;

        return $this;
    }

    public function getSubscriberRegion(): ?string
    {
        return $this->subscriber_region;
    }

    public function setSubscriberRegion(?string $subscriber_region): self
    {
        $this->subscriber_region = $subscriber_region;

        return $this;
    }
}
