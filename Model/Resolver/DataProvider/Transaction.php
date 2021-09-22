<?php

declare(strict_types=1);

namespace Paynl\Graphql\Model\Resolver\DataProvider;

use Paynl\Payment\Model\Config;
use \Exception;

class Transaction
{
    public $whitelist = [
        'orderId',
        'state',
        'stateName',
        'currency',
        'amount',
        'currenyAmount',
        'paidAmount',
        'paidCurrenyAmount',
        'refundAmount',
        'refundCurrenyAmount',
        'created',
        'orderNumber',
    ];

    public function __construct(
        Config $config
    ) {
        $this->config   = $config;
    }

    public function getTransactionData($payOrderId)
    {
        $transaction = $this->getTransaction($payOrderId);
        $data = array_intersect_key($transaction->getData()['paymentDetails'], array_flip($this->whitelist));
        $data['isSuccess'] = ($transaction->isPaid() || $transaction->isAuthorized() || $transaction->isPending());

        return $data;
    }

    public function getTransaction($payOrderId)
    {
        \Paynl\Config::setApiToken($this->config->getApiToken());

        return \Paynl\Transaction::status($payOrderId);
    }
}

