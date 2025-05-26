<?php

class Image{
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

    public function __construct(){
        $this->uploadedAt = new \DateTimeImmutable();
    }
}
