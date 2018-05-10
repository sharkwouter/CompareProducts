<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StoreCategoryRepository")
 */
class StoreCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Store", inversedBy="storeCategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $store;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="storeCategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $productListQuery;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nextPageQuery;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $productNameQuery;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productPriceQuery;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productImageQuery;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $productUrlQuery;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productEanQuery;

    public function getId()
    {
        return $this->id;
    }

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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

    public function getProductListQuery(): ?string
    {
        return $this->productListQuery;
    }

    public function setProductListQuery(string $productListQuery): self
    {
        $this->productListQuery = $productListQuery;

        return $this;
    }

    public function getNextPageQuery(): ?string
    {
        return $this->nextPageQuery;
    }

    public function setNextPageQuery(string $nextPageQuery): self
    {
        $this->nextPageQuery = $nextPageQuery;

        return $this;
    }

    public function getProductNameQuery(): ?string
    {
        return $this->productNameQuery;
    }

    public function setProductNameQuery(string $productNameQuery): self
    {
        $this->productNameQuery = $productNameQuery;

        return $this;
    }

    public function getProductPriceQuery(): ?string
    {
        return $this->productPriceQuery;
    }

    public function setProductPriceQuery(string $productPriceQuery): self
    {
        $this->productPriceQuery = $productPriceQuery;

        return $this;
    }

    public function getProductImageQuery(): ?string
    {
        return $this->productImageQuery;
    }

    public function setProductImageQuery(?string $productImageQuery): self
    {
        $this->productImageQuery = $productImageQuery;

        return $this;
    }

    public function getProductUrlQuery(): ?string
    {
        return $this->productUrlQuery;
    }

    public function setProductUrlQuery(string $productUrlQuery): self
    {
        $this->productUrlQuery = $productUrlQuery;

        return $this;
    }

    public function getProductEanQuery(): ?string
    {
        return $this->productEanQuery;
    }

    public function setProductEanQuery(?string $productEanQuery): self
    {
        $this->productEanQuery = $productEanQuery;

        return $this;
    }
}
