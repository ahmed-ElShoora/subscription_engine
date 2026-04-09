<?php

if (!function_exists('convert_currency')) {
    function convert_currency($amount, $from = 'USD', $to = 'USD')
    {
        $rates = [
            'USD' => 1,
            'EGP' => 53.35,
            'AED' => 3.67,
        ];
        $amountInUsd = $amount / $rates[$from];
        return round($amountInUsd * $rates[$to], 2);
    }
}