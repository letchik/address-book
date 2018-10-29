<?php

namespace App\Entity;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FileRepository")
 * @ORM\HasLifecycleCallbacks
 */
class File
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mime;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\Column(type="string", length=36, unique=true)
     */
    private $key;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getMime(): ?string
    {
        return $this->mime;
    }

    public function setMime(string $mime): self
    {
        $this->mime = $mime;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function __toString() : string
    {
        return $this->path . '/' . $this->filename;
    }

    /**
     * @ORM\PreRemove
     * Seems to be a Doctrine bug. Without initializing the entity somehow (via preRemove or fetch=eager),
     * doctrine initializes entity in a wrong way.
     * @see https://stackoverflow.com/questions/21281659/symfony-doctrine-2-postremove-remove-file-strange-behavior
     *
     */
    public function preRemove() : void
    {
        $this->getPath();
    }

    /**
     * @ORM\PostRemove
     * @param LifecycleEventArgs $eventArgs
     */
    public function removeFile(LifecycleEventArgs $eventArgs) : void
    {
        $entity = $eventArgs->getEntity();
        if ($file = realpath($entity->getPath() . '/' . $entity->getFilename())) {
            unlink($file);
        }
    }
}
