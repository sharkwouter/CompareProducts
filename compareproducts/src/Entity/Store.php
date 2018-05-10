<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StoreRepository")
 */
class Store
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StoreCategory", mappedBy="store", orphanRemoval=true)
     */
    private $storeCategories;

    public function __construct()
    {
        $this->storeCategories = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection|StoreCategory[]
     */
    public function getStoreCategories(): Collection
    {
        return $this->storeCategories;
    }

    public function addStoreCategory(StoreCategory $storeCategory): self
    {
        if (!$this->storeCategories->contains($storeCategory)) {
            $this->storeCategories[] = $storeCategory;
            $storeCategory->setStore($this);
        }

        return $this;
    }

    public function removeStoreCategory(StoreCategory $storeCategory): self
    {
        if ($this->storeCategories->contains($storeCategory)) {
            $this->storeCategories->removeElement($storeCategory);
            // set the owning side to null (unless already changed)
            if ($storeCategory->getStore() === $this) {
                $storeCategory->setStore(null);
            }
        }

        return $this;
    }
}
