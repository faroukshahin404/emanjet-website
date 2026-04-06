<?php

namespace App\Traits;

use App\Services\QNBPaymentService;

trait QNBPaymentIntegration
{
    protected function initiateQNBPaymentLink(array $data): array
    {
        $service = new QNBPaymentService('web');

        return $service->initiateQNBPaymentLink($data);
    }
}
