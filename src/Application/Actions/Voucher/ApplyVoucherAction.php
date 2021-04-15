<?php
declare(strict_types=1);

namespace App\Application\Actions\Voucher;


use App\Application\Actions\Action;
use App\Domain\Voucher\VoucherRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ApplyVoucherAction extends Action
{
    /**
     * @var VoucherRepository
     */
    protected $voucherRepository;

    /**
     * @param LoggerInterface $logger
     * @param VoucherRepository $voucherRepository
     */
    public function __construct(LoggerInterface $logger,
                                VoucherRepository $voucherRepository
    ) {
        parent::__construct($logger);
        $this->voucherRepository = $voucherRepository;
    }

    protected function action(): Response
    {
        $body = $this->request->getParsedBody();
        $items = $body['items'];
        $code = $body['code'];

        $order = $this->voucherRepository->applyVoucher($items, $code);

        // Build the HTTP response
        $this->response->getBody()
            ->write((string)json_encode(['items' => $order->getItems(), 'code' => $order->getCode()]));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}