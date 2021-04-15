<?php
declare(strict_types=1);

namespace App\Domain\Voucher;

use App\Domain\DomainException\DomainException;

class VoucherInvalidException extends DomainException
{
    public $message = 'Voucher is invalid.';
}
