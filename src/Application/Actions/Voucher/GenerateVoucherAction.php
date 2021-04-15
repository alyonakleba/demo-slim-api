<?php
declare(strict_types=1);

namespace App\Application\Actions\Voucher;


use App\Application\Actions\Action;
use App\Domain\Voucher\VoucherRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class GenerateVoucherAction extends Action
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
        $data = (array)$this->request->getParsedBody();
        $voucher = $this->voucherRepository->generateVoucher($data['discount']);

        // Build the HTTP response
        $this->response->getBody()
            ->write((string)json_encode(['code' => $voucher->getCode()]));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}