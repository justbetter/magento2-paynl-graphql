<?php

declare(strict_types=1);

namespace Paynl\Graphql\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class StartTransaction implements ResolverInterface
{

    private $startTransactionDataProvider;

    /**
     * @param DataProvider\StartTransaction $startTransactionRepository
     */
    public function __construct(
        DataProvider\StartTransaction $startTransactionDataProvider
    ) {
        $this->startTransactionDataProvider = $startTransactionDataProvider;
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
        return $this->startTransactionDataProvider->startTransaction($args);
    }
}

