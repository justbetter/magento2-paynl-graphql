<?php

declare(strict_types=1);

namespace Paynl\Graphql\Model\Resolver\DataProvider;

use Magento\Payment\Helper\Data as PaymentHelper;
use Magento\Quote\Model\QuoteRepository;
use Magento\Sales\Model\OrderRepository;

class StartTransaction
{
    public function __construct(
        QuoteRepository $quoteRepository,
        OrderRepository $orderRepository,
        PaymentHelper $paymentHelper
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->paymentHelper   = $paymentHelper;
        $this->orderRepository = $orderRepository;
    }

    public function startTransaction($options)
    {
        $order = $this->orderRepository->get($options['order_id']);
        $quote = $this->quoteRepository->get($order->getQuoteId());
        $quote->setIsActive(true);
        $this->quoteRepository->save($quote);

        $payment = $order->getPayment();
        if ($options['return_url']) {
            $payment->setAdditionalInformation('returnUrl', $options['return_url']);
        }

        $methodInstance = $this->paymentHelper->getMethodInstance($payment->getMethod());
        if ($methodInstance instanceof \Paynl\Payment\Model\Paymentmethod\Paymentmethod) {
            $redirectUrl = $methodInstance->startTransaction($order);
        }

        return ['redirectUrl' => $redirectUrl];
    }
}

