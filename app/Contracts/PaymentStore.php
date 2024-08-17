<?php


namespace App\Contracts;


interface PaymentStore
{
    /**
     * Store payment request
     *
     * @param int $orderId Payment unique order id
     * @param  null  $token
     * @param  string  $type One of 'ONLINE', 'CHEQUE', 'CASH', 'CARD', 'CASH_ON_DELIVERY'
     *
     * @return \App\Models\Payment
     */
    public function storePaymentRequest($orderId,$amount, $token = null, $type = 'ONLINE',$bank=null): \App\Models\Payment;

    /**
     * Store success payment and update invoice status
     *
     * @param int $paymentId Payment unique order id
     * @param string|int $referenceId Transaction reference id
     * @param  null  $cardNumber
     *
     * @return \App\Models\Payment
     */
    public function storeSuccessPayment($paymentId, $referenceId, $cardNumber = null): \App\Models\Payment;

    /**
     * Store failed payment and update invoice status
     *
     * @param int $orderId Payment unique order id
     * @param  null  $message Fail reason text to store
     *
     * @return \App\Models\Payment
     */
    public function storeFailPayment($orderId, $message = null): \App\Models\Payment;
}
