<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class File
{
    private $id;

    private $name;

    private $type;

    private $path;

    private $sharedLink;

    public function getId(): ?int { return $this->id; }
    public function getName(): ?string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    public function getType(): ?string { return $this->type; }
    public function setType(string $type): self { $this->type = $type; return $this; }
    public function getPath(): ?string { return $this->path; }
    public function setPath(string $path): self { $this->path = $path; return $this; }
    public function getSharedLink(): ?string { return $this->sharedLink; }
    public function setSharedLink(?string $sharedLink): self { $this->sharedLink = $sharedLink; return $this; }
}
