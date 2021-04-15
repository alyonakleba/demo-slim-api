<?php
declare(strict_types=1);

namespace App\Domain\Voucher;


interface VoucherRepository
{

    public function generateVoucher($discount);

    public function applyVoucher($items, $code);


}