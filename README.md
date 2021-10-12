# Magento2 Module Paynl Graphql

This module aims to add basic GraphQL support for the [paynl module for Magento 2](https://github.com/paynl/magento2-plugin)

To use `return_url` you will need `paynl/magento2-plugin` version 2.4.0+

## Installation

To install this module you can run
`composer require indykoning/module-paynl-graphql`

To get the full functionality of setting the return url you should

## GraphQL

These are the GraphQL queries this module adds.

### Query

#### paynlTransaction

This query expects `pay_order_id` as an argument. It will return [#PaynlTransactionOutput](#paynltransactionoutput)

### Mutation

#### paynlStartTransaction

This query expects `order_id` and optionally `return_url`. It will return [#PaynlStartTransactionOutput](#paynlstarttransactionoutput)

#### paynlFinishTransaction

This query expects the `pay_order_id`. It will return [#PaynlTransactionOutput](#paynltransactionoutput)

### Types

#### PaynlTransactionOutput

| Variable            | Type    | Description                                   |
| ------------------- | ------- | --------------------------------------------- |
| orderId             | String  | The Pay order id.                             |
| state               | Int     | The State number.                             |
| stateName           | String  | The State name.                               |
| currency            | String  | The currency used to pay.                     |
| amount              | String  | The amount in cents.                          |
| currenyAmount       | String  | The amount in cents in the curency.           |
| paidAmount          | String  | The paid amount in cents.                     |
| paidCurrenyAmount   | String  | The paid amount in cents in the curency.      |
| refundAmount        | String  | The refunded amount in cents.                 |
| refundCurrenyAmount | String  | The refunded amount in cents in the curency.  |
| created             | String  | Created at date.                              |
| orderNumber         | String  | The Order increment id for the Magento order. |
| isSuccess           | Boolean | Was the payment successfull.                  |

#### PaynlStartTransactionOutput

| Variable    | Type   | Description                              |
| ----------- | ------ | ---------------------------------------- |
| redirectUrl | String | The url to redirect to the pay checkout. |
