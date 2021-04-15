<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Voucher;


use App\Domain\Order\Order;
use App\Domain\Voucher\VoucherInvalidException;
use App\Domain\Voucher\VoucherNotCreatedException;
use App\Domain\Voucher\VoucherNotFoundException;
use App\Domain\Voucher\Voucher;
use App\Domain\Voucher\VoucherRepository;
use PDO;

class DbVoucherRepository implements VoucherRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * DbUserRepository constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $discount
     * @return Voucher|null
     * @throws VoucherNotCreatedException
     */
    public function generateVoucher($discount)
    {
        $code = $this->generateCode();
        $voucher = new Voucher($discount, $code);
        if ($this->saveVoucher($voucher)) {
            return $voucher;
        }
        return null;
    }

    /**
     * @param $items
     * @param $code
     * @return Order
     * @throws VoucherInvalidException
     * @throws VoucherNotFoundException
     */
    public function applyVoucher($items, $code)
    {
        $voucher = $this->readVoucher($code);
        $discount = $voucher->getDiscount();

        $totalPrice = array_sum(array_column($items, 'price'));

        if ($discount > $totalPrice) {
            $discount = $totalPrice;
            //throw new VoucherInvalidException();
        }

        $relativeDiscount = ($discount * 100) / $totalPrice;
        $effectiveDiscount = 0;
        $maxPrice = 0;
        $maxPriceKey = 0;
        foreach ($items as $key => &$item) {
            $itemDiscount = round(($item['price'] * $relativeDiscount) / 100, 0, PHP_ROUND_HALF_DOWN);
            $effectiveDiscount += $itemDiscount;
            $item['price_with_discount'] = $item['price'] - $itemDiscount;

            if ($item['price_with_discount'] > $maxPrice) {
                $maxPrice = $item['price_with_discount'];
                $maxPriceKey = $key;
            }
        }

        if (($discountDiff = $discount - $effectiveDiscount) != 0 ) {
            $items[$maxPriceKey]['price_with_discount'] -= $discountDiff;
        }

        return new Order($items, $code);
    }

    /**
     * @param string $code
     * @return Voucher
     * @throws VoucherNotFoundException
     */
    private function readVoucher(string $code)
    {
        $sql = "SELECT code, discount FROM vouchers WHERE code = :code;";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":code", $code);
        $statement->execute();
        $data = $statement->fetch();

        if (empty($data)) {
            throw new VoucherNotFoundException();
        }

        return new Voucher($data['discount'], $data['code']);
    }

    /**
     * @param Voucher $voucher
     * @return bool
     * @throws VoucherNotCreatedException
     */
    private function saveVoucher(Voucher $voucher)
    {
        $code = $voucher->getCode();
        $dicscount = $voucher->getDiscount();

        $sql = "INSERT INTO vouchers (code, discount) VALUES (:code, :discount) ;";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":code", $code);
        $statement->bindParam(":discount", $dicscount);

        if(!$statement->execute()) {
            throw new VoucherNotCreatedException();
        }

        return true;
    }

    /**
     * @param int $length
     * @return string
     */
    private function generateCode($length = 7)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $string;
    }
}