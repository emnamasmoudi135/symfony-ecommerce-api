<?php

namespace App\Entity;

use App\Repository\SalesOrderLineRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SalesOrderLineRepository::class)
 */
class SalesOrderLine
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Discount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Item;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ItemDescription;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Quantity;

    /**
     * @ORM\Column(type="string", length=255 ,nullable=true)
     */
    private $UnitCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $UnitDescription;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $UnitPrice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $VATAmount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $VATPercentage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commande", inversedBy="salesOrderLines")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->Discount;
    }

    public function setDiscount(?int $Discount): self
    {
        $this->Discount = $Discount;

        return $this;
    }

    public function getItem(): ?string
    {
        return $this->Item;
    }

    public function setItem(?string $Item): self
    {
        $this->Item = $Item;

        return $this;
    }

    public function getItemDescription(): ?string
    {
        return $this->ItemDescription;
    }

    public function setItemDescription(?string $ItemDescription): self
    {
        $this->ItemDescription = $ItemDescription;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->Quantity;
    }

    public function setQuantity(?int $Quantity): self
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    public function getUnitCode(): ?string
    {
        return $this->UnitCode;
    }

    public function setUnitCode(?string $UnitCode): self
    {
        $this->UnitCode = $UnitCode;

        return $this;
    }

    public function getUnitDescription(): ?string
    {
        return $this->UnitDescription;
    }

    public function setUnitDescription(?string $UnitDescription): self
    {
        $this->UnitDescription = $UnitDescription;

        return $this;
    }

    public function getUnitPrice(): ?int
    {
        return $this->UnitPrice;
    }

    public function setUnitPrice(?int $UnitPrice): self
    {
        $this->UnitPrice = $UnitPrice;

        return $this;
    }

    public function getVATAmount(): ?int
    {
        return $this->VATAmount;
    }

    public function setVATAmount(?int $VATAmount): self
    {
        $this->VATAmount = $VATAmount;

        return $this;
    }

    public function getVATPercentage(): ?int
    {
        return $this->VATPercentage;
    }

    public function setVATPercentage(?int $VATPercentage): self
    {
        $this->VATPercentage = $VATPercentage;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }
}
