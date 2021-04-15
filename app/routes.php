<?php
declare(strict_types=1);

use App\Application\Actions\Voucher\ApplyVoucherAction;
use App\Application\Actions\Voucher\GenerateVoucherAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->post('/generate', GenerateVoucherAction::class);
    $app->post('/apply', ApplyVoucherAction::class);
};
