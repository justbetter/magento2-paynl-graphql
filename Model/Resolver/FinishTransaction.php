<?php

declare(strict_types=1);

namespace Paynl\Graphql\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Quote\Model\QuoteRepository;
use Magento\Sales\Api\Data\OrderInterface;

class FinishTransaction implements ResolverInterface
{

    private $transactionDataProvider;

    /**
     * @param DataProvider\StartTransaction $startTransactionRepository
     */
    public function __construct(
        DataProvider\Transaction $transactionDataProvider,
        QuoteRepository $quoteRepository,
        OrderInterface $orderInterface
    ) {
        $this->transactionDataProvider = $transactionDataProvider;
        $this->quoteRepository = $quoteRepository;
        $this->orderInterface = $orderInterface;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $transactionData = $this->transactionDataProvider->getTransactionData($args['pay_order_id']);
        if (!$transactionData['isSuccess']) {
            return $transactionData;
        }

        $order = $this->orderInterface->loadByIncrementId($transactionData['orderNumber']);
        $quote = $this->quoteRepository->get($order->getQuoteId());

        $quote->setIsActive(false);
        $this->quoteRepository->save($quote);

        return $transactionData;
    }
}

