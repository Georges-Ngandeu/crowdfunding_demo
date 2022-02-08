<?php

namespace App\Entity;

use App\Repository\SubscriberProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubscriberProjectRepository::class)
 */
class SubscriberProject
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $subscription_createdate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $subscription_number;

    /**
     * @ORM\Column(type="json")
     */
    private $subscription_mobile_account = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $subscription_bank_account = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subscription_campaign_awareness;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $subscription_partner = [];

    /**
     * @ORM\ManyToOne(targetEntity=Subscriber::class, inversedBy="subscriber_project", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $subscriber_id;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="project_subscriber", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $project_id;

    /**
     * @ORM\ManyToOne(targetEntity=Manager::class, inversedBy="manager_subscription", cascade={"persist"})
     */
    private $manager_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subscription_mobile_operator;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $subscription_partner_option;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $subscription_status;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $subscription_payment = [];

    /**
     * SubscriberProject constructor.
     */
    public function __construct()
    {
        $this->subscription_createdate = new \DateTime();
        $this->subscription_status = False;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubscriptionCreatedate(): ?\DateTimeInterface
    {
        return $this->subscription_createdate;
    }

    public function setSubscriptionCreatedate(\DateTimeInterface $subscription_createdate): self
    {
        $this->subscription_createdate = $subscription_createdate;

        return $this;
    }

    public function getSubscriptionNumber(): ?float
    {
        return $this->subscription_number;
    }

    public function setSubscriptionNumber(float $subscription_number): self
    {
        $this->subscription_number = $subscription_number;

        return $this;
    }

    public function getSubscriptionMobileAccount(): ?array
    {
        return $this->subscription_mobile_account;
    }

    public function setSubscriptionMobileAccount(array $subscription_mobile_account): self
    {
        $this->subscription_mobile_account = $subscription_mobile_account;

        return $this;
    }

    public function getSubscriptionBankAccount(): ?array
    {
        return $this->subscription_bank_account;
    }

    public function setSubscriptionBankAccount(?array $subscription_bank_account): self
    {
        $this->subscription_bank_account = $subscription_bank_account;

        return $this;
    }

    public function getSubscriptionCampaignAwareness(): ?string
    {
        return $this->subscription_campaign_awareness;
    }

    public function setSubscriptionCampaignAwareness(string $subscription_campaign_awareness): self
    {
        $this->subscription_campaign_awareness = $subscription_campaign_awareness;

        return $this;
    }

    public function getSubscriptionPartner(): ?array
    {
        return $this->subscription_partner;
    }

    public function setSubscriptionPartner(?array $subscription_partner): self
    {
        $this->subscription_partner = $subscription_partner;

        return $this;
    }

    public function getSubscriberId(): ?Subscriber
    {
        return $this->subscriber_id;
    }

    public function setSubscriberId(?Subscriber $subscriber_id): self
    {
        $this->subscriber_id = $subscriber_id;

        return $this;
    }

    public function getProjectId(): ?Project
    {
        return $this->project_id;
    }

    public function setProjectId(?Project $project_id): self
    {
        $this->project_id = $project_id;

        return $this;
    }

    public function getManagerId(): ?Manager
    {
        return $this->manager_id;
    }

    public function setManagerId(?Manager $manager_id): self
    {
        $this->manager_id = $manager_id;

        return $this;
    }

    public function getSubscriptionMobileOperator(): ?string
    {
        return $this->subscription_mobile_operator;
    }

    public function setSubscriptionMobileOperator(?string $subscription_mobile_operator): self
    {
        $this->subscription_mobile_operator = $subscription_mobile_operator;

        return $this;
    }

    public function getSubscriptionPartnerOption(): ?bool
    {
        return $this->subscription_partner_option;
    }

    public function setSubscriptionPartnerOption(?bool $subscription_partner_option): self
    {
        $this->subscription_partner_option = $subscription_partner_option;

        return $this;
    }

    public function getSubscriptionStatus(): ?bool
    {
        return $this->subscription_status;
    }

    public function setSubscriptionStatus(?bool $subscription_status): self
    {
        $this->subscription_status = $subscription_status;

        return $this;
    }

    public function getSubscriptionPayment(): ?array
    {
        return $this->subscription_payment;
    }

    public function setSubscriptionPayment(?array $subscription_payment): self
    {
        $this->subscription_payment = $subscription_payment;

        return $this;
    }
}
