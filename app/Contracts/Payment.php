<?php

namespace App\Contracts;

interface Payment
{

    /**
     * Register Payment Service Provider
     *
     * @return self
     */
    public static function registerService();

    /**
     * Get Payment name
     *
     * @return string
     */
    public static function getName(): string;

    /**
     * Get payment type must be one of: ONLINE, CHEQUE, CARD, CASH, CASH_ON_DELIVERY
     *
     * @return string
     */
    public static function getType(): string;

    /**
     * Is Active To Show user
     *
     * @return bool
     */
    public static function isActive(): bool;

    /**
     * Gateway Logo
     *
     * @return string
     */
    public static function getLogo();

    /**
     * Request online payment
     *
     * @param  int  $amount  transaction amount
     * @param  string  $callbackUrl  a url that callback user after transaction
     * @param  array  $additionalData  additional data to send back
     *
     * @return array request data like token and order id
     * @throws \Throwable
     */
    public function request(int $amount, string $callbackUrl, array $additionalData = []): array;

    /**
     * Redirect customer to bank payment page
     */
    public function goToBank();

    /**
     * Verify payment
     *
     * @return array successful payment have two keys: reference_id , card_number
     * @throws \Throwable if payment fail
     */
    public function verify(): array;
}
