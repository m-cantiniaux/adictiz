<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $filename;

    #[ORM\Column(length: 255)]
    private string $url;

    #[ORM\Column]
    private \DateTimeImmutable $uploadedAt;

    public function __construct() {
        $this->uploadedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getFilename(): string {
        return $this->filename;
    }

    public function setFilename(string $filename): self {
        $this->filename = $filename;
        return $this;
    }

    public function getUrl(): string  {
        return $this->url;
    }

    public function setUrl(string $url): self {
        $this->url = $url;
        return $this;
    }

    public function getUploadedAt(): \DateTimeImmutable {
        return $this->uploadedAt;
    }

    public function setUploadedAt(\DateTimeImmutable $uploadedAt): self  {
        $this->uploadedAt = $uploadedAt;
        return $this;
    }
}
