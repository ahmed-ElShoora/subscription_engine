<?php

namespace App\Services\SimulatePayment;
use App\Models\Transaction;

class SimulatePaymentService
{
    public function processPayment(array $data)
    {
        $isValid = $this->validateCard($data);
        $payment_transaction = Transaction::create([
            'user_id' => $data['user_id'],
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'status' => $isValid ? 'completed' : 'rejected',
            'card_last_four' => substr($data['card_number'], -4),
        ]);

        return [
            'status' => $isValid,
            'transaction' => $payment_transaction
        ];
    }

    private function validateCard(array $data): bool
    {
        return (
            $data['card_number'] === '1111111111111111' &&
            $data['cvv'] === '111' &&
            $data['expiry_month'] === '12' &&
            $data['expiry_year'] === '2030'
        );
    }
}