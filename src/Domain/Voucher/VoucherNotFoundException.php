<?php
declare(strict_types=1);

namespace App\Domain\Voucher;

use App\Domain\DomainException\DomainException;

class VoucherNotFoundException extends DomainException
{
    public $message = 'Voucher was not found.';
}
