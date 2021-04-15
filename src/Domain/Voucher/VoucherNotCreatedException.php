<?php
declare(strict_types=1);

namespace App\Domain\Voucher;

use App\Domain\DomainException\DomainException;

class VoucherNotCreatedException extends DomainException
{
    public $message = 'Unable to save voucher.';
}
