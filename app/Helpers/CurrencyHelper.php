<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Convert USD to KES
     */
    public static function usdToKes($usdAmount)
    {
        $rate = env('USD_TO_KES_RATE', 130);
        return round($usdAmount * $rate, 0); // Round to nearest shilling
    }
    
    /**
     * Format amount for M-PESA (whole numbers only)
     */
    public static function formatForMpesa($amount)
    {
        return (int) round($amount); // M-PESA accepts whole numbers only
    }
}