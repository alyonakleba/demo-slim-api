<?php
declare(strict_types=1);

namespace App\Domain\Voucher;


class Voucher
{
    private $discount;
    private $code;

    /**
     * Voucher constructor.
     * @param $discount
     * @param $code
     */
    public function __construct($discount, $code)
    {
        $this->discount = $discount;
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param $discount
     */
    public function setDiscount($discount): Voucher
    {
        $this->discount = $discount;
        return $this;
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
    public function setCode($code): Voucher
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'code' => $this->code,
            'discount' => $this->discount
        ];
    }

}