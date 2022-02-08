<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    const SERVER_PATH_TO_IMAGE_FOLDER = 'companies_documents';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $project_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $project_shortdescription;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $project_cost;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $project_engaged;

    /**
     * @ORM\Column(type="datetime")
     */
    private $project_startdate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $project_enddate;

    /**
     * @ORM\Column(type="json")
     */
    private $project_images = [];

    /**
     * @ORM\Column(type="json")
     */
    private $project_documents = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $project_creationdate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $project_mainimage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $project_videourl;

    /**
     * @ORM\Column(type="boolean")
     */
    private $project_publish;

    /**
     * @ORM\Column(type="text")
     */
    private $project_longdescription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $project_group;

    /**
     * @ORM\Column(type="float")
     */
    private $project_numberaction;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $project_priceaction;

    /**
     * @ORM\Column(type="float")
     */
    private $project_minnumberaction;

    /**
     * @ORM\OneToMany(targetEntity=SubscriberProject::class, mappedBy="project_id")
     */
    private $project_subscriber;

    /**
     * Unmapped property to handle document uploads
     */
    private $documentfile;

    /**
     * @return mixed
     */
    public function getDocumentfile()
    {
        return $this->documentfile;
    }

    /**
     * @param mixed $documentfile
     */
    public function setDocumentfile($documentfile)
    {
        $this->documentfile = $documentfile;
    }

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

    /**
     * Unmapped property to handle image uploads
     */
    private $imagefile;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $project_numbercontributions;


    public function __construct()
    {
        $this->project_subscriber = new ArrayCollection();
        $this->project_creationdate = new \DateTime();
        $this->project_publish = False;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectName(): ?string
    {
        return $this->project_name;
    }

    public function setProjectName(string $project_name): self
    {
        $this->project_name = $project_name;

        return $this;
    }

    public function getProjectShortdescription(): ?string
    {
        return $this->project_shortdescription;
    }

    public function setProjectShortdescription(string $project_shortdescription): self
    {
        $this->project_shortdescription = $project_shortdescription;

        return $this;
    }

    public function getProjectCost(): ?string
    {
        return $this->project_cost;
    }

    public function setProjectCost(string $project_cost): self
    {
        $this->project_cost = $project_cost;

        return $this;
    }

    public function getProjectEngaged(): ?float
    {
        return $this->project_engaged;
    }

    public function setProjectEngaged(?float $project_engaged): self
    {
        $this->project_engaged = $project_engaged;

        return $this;
    }

    public function getProjectStartdate(): ?\DateTimeInterface
    {
        return $this->project_startdate;
    }

    public function setProjectStartdate(\DateTimeInterface $project_startdate): self
    {
        $this->project_startdate = $project_startdate;

        return $this;
    }

    public function getProjectEnddate(): ?\DateTimeInterface
    {
        return $this->project_enddate;
    }

    public function setProjectEnddate(\DateTimeInterface $project_enddate): self
    {
        $this->project_enddate = $project_enddate;

        return $this;
    }

    public function getProjectImages(): ?array
    {
        return $this->project_images;
    }

    public function setProjectImages(array $project_images): self
    {
        $this->project_images = $project_images;

        return $this;
    }

    public function getProjectDocuments(): ?array
    {
        return $this->project_documents;
    }

    public function setProjectDocuments(array $project_documents): self
    {
        $this->project_documents = $project_documents;

        return $this;
    }

    public function getProjectCreationdate(): ?\DateTimeInterface
    {
        return $this->project_creationdate;
    }

    public function setProjectCreationdate(\DateTimeInterface $project_creationdate): self
    {
        $this->project_creationdate = $project_creationdate;

        return $this;
    }

    public function getProjectMainimage(): ?string
    {
        return $this->project_mainimage;
    }

    public function setProjectMainimage(string $project_mainimage): self
    {
        $this->project_mainimage = $project_mainimage;

        return $this;
    }

    public function getProjectVideourl(): ?string
    {
        return $this->project_videourl;
    }

    public function setProjectVideourl(string $project_videourl): self
    {
        $this->project_videourl = $project_videourl;

        return $this;
    }

    public function getProjectPublish(): ?bool
    {
        return $this->project_publish;
    }

    public function setProjectPublish(bool $project_publish): self
    {
        $this->project_publish = $project_publish;

        return $this;
    }

    public function getProjectLongdescription(): ?string
    {
        return $this->project_longdescription;
    }

    public function setProjectLongdescription(string $project_longdescription): self
    {
        $this->project_longdescription = $project_longdescription;

        return $this;
    }

    public function getProjectGroup(): ?string
    {
        return $this->project_group;
    }

    public function setProjectGroup(?string $project_group): self
    {
        $this->project_group = $project_group;

        return $this;
    }

    public function getProjectNumberaction(): ?float
    {
        return $this->project_numberaction;
    }

    public function setProjectNumberaction(float $project_numberaction): self
    {
        $this->project_numberaction = $project_numberaction;

        return $this;
    }

    public function getProjectPriceaction(): ?float
    {
        return $this->project_priceaction;
    }

    public function setProjectPriceaction(float $project_priceaction): self
    {
        $this->project_priceaction = $project_priceaction;

        return $this;
    }

    public function getProjectMinnumberaction(): ?float
    {
        return $this->project_minnumberaction;
    }

    public function setProjectMinnumberaction(float $project_minnumberaction): self
    {
        $this->project_minnumberaction = $project_minnumberaction;

        return $this;
    }

    /**
     * @return Collection|SubscriberProject[]
     */
    public function getProjectSubscriber(): Collection
    {
        return $this->project_subscriber;
    }

    public function addProjectSubscriber(SubscriberProject $projectSubscriber): self
    {
        if (!$this->project_subscriber->contains($projectSubscriber)) {
            $this->project_subscriber[] = $projectSubscriber;
            $projectSubscriber->setProjectId($this);
        }

        return $this;
    }

    public function removeProjectSubscriber(SubscriberProject $projectSubscriber): self
    {
        if ($this->project_subscriber->contains($projectSubscriber)) {
            $this->project_subscriber->removeElement($projectSubscriber);
            // set the owning side to null (unless already changed)
            if ($projectSubscriber->getProjectId() === $this) {
                $projectSubscriber->setProjectId(null);
            }
        }

        return $this;
    }

    public function getTodaysDate(){

        return new \DateTime();
    }

    public function getRemainingDate(){

        $campaignTime = $this->getProjectEnddate()->diff($this->getProjectStartdate())->format("%d");
        $consumedTime = $this->getProjectStartdate()->diff($this->getTodaysDate())->format("%d");
        $result = $campaignTime - $consumedTime;

        return $result;
    }

    public function getProjectNumbercontributions(): ?float
    {
        return $this->project_numbercontributions;
    }

    public function setProjectNumbercontributions(?float $project_numbercontributions): self
    {
        $this->project_numbercontributions = $project_numbercontributions;

        return $this;
    }

}
