<?php

namespace App\Services;

use App\Entity\StockTable;
use Doctrine\ORM\EntityManagerInterface;

class HomeService
{
  /**
   * Instance of Entity Manager Interface
   * @var EntityManagerInterface
   */
  private $em = null;


  /**
   * Function to initilize the values, achieved.
   * 
   */
  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }


  public function isStockUpdated($stock_id)
  {
    $stock = $this->em->getRepository(Product::class)->find($stock_id);
  }
}

