<?php
declare(strict_types=1);

namespace App\Domain\Order;


class Order
{
    private $items;
    private $code;

    /**
     * Order constructor.
     * @param $items
     * @param $code
     */
    public function __construct($items, $code)
    {
        $this->items = $items;
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items): void
    {
        $this->items = $items;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

}