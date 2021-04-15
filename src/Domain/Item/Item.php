<?php
declare(strict_types=1);

namespace App\Domain\Item;


class Item
{
    private $id;
    private $price;
    private $priceWithDiscount;

    /**
     * Item constructor.
     * @param $id
     * @param $price
     * @param $priceWithDiscount
     */
    public function __construct($id, $price, $priceWithDiscount)
    {
        $this->id = $id;
        $this->price = $price;
        $this->priceWithDiscount = $priceWithDiscount;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getPriceWithDiscount()
    {
        return $this->priceWithDiscount;
    }

    /**
     * @param mixed $priceWithDiscount
     */
    public function setPriceWithDiscount($priceWithDiscount): void
    {
        $this->priceWithDiscount = $priceWithDiscount;
    }


}