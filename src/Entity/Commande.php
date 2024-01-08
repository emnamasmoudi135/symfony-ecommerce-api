<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
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
    private $currency;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $DeliverTo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $OrderID;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $OrderNumber;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SalesOrderLine", mappedBy="commande", cascade={"persist", "remove"})
     */
    private $salesOrderLines;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class, inversedBy="commandes")
     * @ORM\JoinTable(name="lignes_commande",
     *      joinColumns={@ORM\JoinColumn(name="commande_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")}
     * )
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity=LigneCommande::class, mappedBy="commande", orphanRemoval=true, cascade={"persist"})
     */
    private $lignesCommande;

    public function __construct()
    {
        $this->salesOrderLines = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->lignesCommande = new ArrayCollection(); // Correction ici
    }

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

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getDeliverTo(): ?string
    {
        return $this->DeliverTo;
    }

    public function setDeliverTo(?string $DeliverTo): self
    {
        $this->DeliverTo = $DeliverTo;

        return $this;
    }

    public function getOrderID(): ?string
    {
        return $this->OrderID;
    }

    public function setOrderID(?string $OrderID): self
    {
        $this->OrderID = $OrderID;

        return $this;
    }

    public function getOrderNumber(): ?int
    {
        return $this->OrderNumber;
    }

    public function setOrderNumber(?int $OrderNumber): self
    {
        $this->OrderNumber = $OrderNumber;

        return $this;
    }

    /**
     * @return Collection<int, SalesOrderLine>
     */
    public function getSalesOrderLines(): Collection
    {
        return $this->salesOrderLines;
    }

    public function addSalesOrderLine(SalesOrderLine $salesOrderLine): self
    {
        if (!$this->salesOrderLines->contains($salesOrderLine)) {
            $this->salesOrderLines[] = $salesOrderLine;
            $salesOrderLine->setCommande($this);
        }

        return $this;
    }

    public function removeSalesOrderLine(SalesOrderLine $salesOrderLine): self
    {
        if ($this->salesOrderLines->removeElement($salesOrderLine)) {
            // set the owning side to null (unless already changed)
            if ($salesOrderLine->getCommande() === $this) {
                $salesOrderLine->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        $this->articles->removeElement($article);

        return $this;
    }

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLignesCommande(): Collection
    {
        return $this->lignesCommande;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->lignesCommande->contains($ligneCommande)) {
            $this->lignesCommande[] = $ligneCommande;
            $ligneCommande->setCommande($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->lignesCommande->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getCommande() === $this) {
                $ligneCommande->setCommande(null);
            }
        }

        return $this;
    }








}