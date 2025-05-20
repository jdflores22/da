<?php

namespace App\Entity;

use App\Repository\EntryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntryRepository::class)]
#[ORM\Table(name: '`entries`')]
class Entry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 20)]
    private ?string $entryNumber = null;

    #[ORM\Column(length: 50)]
    private ?string $agency = null;

    #[ORM\Column(length: 100)]
    private ?string $client = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column(length: 50)]
    private ?string $status = 'pending';

    #[ORM\Column]
    private ?\DateTimeImmutable $submissionDate = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $inspector = null;

    // BAI specific fields
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $animalType = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $healthStatus = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $vaccinationStatus = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $quarantinePeriod = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $healthCertificate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $testResults = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $inspectionNotes = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $comments = null;

    public function __construct()
    {
        $this->submissionDate = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getEntryNumber(): ?string
    {
        return $this->entryNumber;
    }

    public function setEntryNumber(string $entryNumber): static
    {
        $this->entryNumber = $entryNumber;
        return $this;
    }

    public function getAgency(): ?string
    {
        return $this->agency;
    }

    public function setAgency(string $agency): static
    {
        $this->agency = $agency;
        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(string $client): static
    {
        $this->client = $client;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getSubmissionDate(): ?\DateTimeImmutable
    {
        return $this->submissionDate;
    }

    public function setSubmissionDate(\DateTimeImmutable $submissionDate): static
    {
        $this->submissionDate = $submissionDate;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getInspector(): ?string
    {
        return $this->inspector;
    }

    public function setInspector(?string $inspector): static
    {
        $this->inspector = $inspector;
        return $this;
    }

    public function getAnimalType(): ?string
    {
        return $this->animalType;
    }

    public function setAnimalType(?string $animalType): static
    {
        $this->animalType = $animalType;
        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): static
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getHealthStatus(): ?string
    {
        return $this->healthStatus;
    }

    public function setHealthStatus(?string $healthStatus): static
    {
        $this->healthStatus = $healthStatus;
        return $this;
    }

    public function getVaccinationStatus(): ?string
    {
        return $this->vaccinationStatus;
    }

    public function setVaccinationStatus(?string $vaccinationStatus): static
    {
        $this->vaccinationStatus = $vaccinationStatus;
        return $this;
    }

    public function getQuarantinePeriod(): ?string
    {
        return $this->quarantinePeriod;
    }

    public function setQuarantinePeriod(?string $quarantinePeriod): static
    {
        $this->quarantinePeriod = $quarantinePeriod;
        return $this;
    }

    public function getHealthCertificate(): ?string
    {
        return $this->healthCertificate;
    }

    public function setHealthCertificate(?string $healthCertificate): static
    {
        $this->healthCertificate = $healthCertificate;
        return $this;
    }

    public function getTestResults(): ?string
    {
        return $this->testResults;
    }

    public function setTestResults(?string $testResults): static
    {
        $this->testResults = $testResults;
        return $this;
    }

    public function getInspectionNotes(): ?string
    {
        return $this->inspectionNotes;
    }

    public function setInspectionNotes(?string $inspectionNotes): static
    {
        $this->inspectionNotes = $inspectionNotes;
        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): static
    {
        $this->comments = $comments;
        return $this;
    }
} 