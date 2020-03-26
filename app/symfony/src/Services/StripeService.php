<?php

namespace App\Services;

use App\Entity\Abonnement;
use App\Entity\Carte;
use App\Entity\Pack;
use App\Entity\Service;
use App\Entity\Subscription;

class StripeService
{
    /**
     * @var string
     */
    private $privateKey;

    public function __construct()
    {
        if ($_ENV['APP_ENV'] == 'dev') {
            $this->privateKey = $_ENV['STRIPE_SECRET_KEY_TEST'];
        } else {
            $this->privateKey = $_ENV['STRIPE_SECRET_KEY_LIVE'];
        }
    }

    /**
     * @param Pack $pack
     * @return \Stripe\PaymentIntent
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function paymentIntent(Pack $pack)
    {
        \Stripe\Stripe::setApiKey($this->privateKey);

        return \Stripe\PaymentIntent::create([
            'amount' => $pack->getPrice() * 100,
            'currency' => Subscription::DEVISE,
            'payment_method_types' => ['card'],
        ]);
    }

    /**
     * @param $amount
     * @param string $currency
     * @param string $description
     * @param array $stripeParameter
     * @return \Stripe\PaymentIntent|null
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function paiement($amount, string $currency, string $description, array $stripeParameter)
    {
        \Stripe\Stripe::setApiKey($this->privateKey);
        $payment_intent = null;

        // stripeIntentId stripeIntentPaymentMethod stripeIntentStatus subscription

        if (isset($stripeParameter['stripeIntentId'])) {
            $payment_intent = \Stripe\PaymentIntent::retrieve(
                $stripeParameter['stripeIntentId']
            );
        }

        if ($stripeParameter['stripeIntentStatus'] == "succeeded") {

        } else {
            $payment_intent->cancel();
        }

        return $payment_intent;
    }

    /**
     * @param array $stripeParameter
     * @param Pack $pack
     * @return \Stripe\Charge|\Stripe\PaymentIntent
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function stripe(array $stripeParameter, Pack $pack)
    {
        return $this->paiement(
            $pack->getPrice() * 100,
            Subscription::DEVISE,
            $pack->getName(),
            $stripeParameter
        );
    }
}