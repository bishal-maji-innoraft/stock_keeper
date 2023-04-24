<?php

namespace App\Entity;

use App\Repository\StockTableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockTableRepository::class)]
class StockTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $create_time = null;

    #[ORM\Column(length: 255)]
    private ?string $stock_name = null;

    #[ORM\Column(length: 255)]
    private ?string $stock_price = null;

    #[ORM\Column(length: 255)]
    private ?string $last_update = null;

    #[ORM\Column(length: 150)]
    private ?string $created_by = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreateTime(): ?string
    {
        return $this->create_time;
    }

    public function setCreateTime(string $create_time): self
    {
        $this->create_time = $create_time;

        return $this;
    }

    public function getStockName(): ?string
    {
        return $this->stock_name;
    }

    public function setStockName(string $stock_name): self
    {
        $this->stock_name = $stock_name;

        return $this;
    }

    public function getStockPrice(): ?string
    {
        return $this->stock_price;
    }

    public function setStockPrice(string $stock_price): self
    {
        $this->stock_price = $stock_price;

        return $this;
    }

    public function getLastUpdate(): ?string
    {
        return $this->last_update;
    }

    public function setLastUpdate(string $last_update): self
    {
        $this->last_update = $last_update;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->created_by;
    }

    public function setCreatedBy(string $created_by): self
    {
        $this->created_by = $created_by;

        return $this;
    }
}
