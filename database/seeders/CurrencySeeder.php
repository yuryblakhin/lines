<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        $currencies = [
            ['code' => 'USD', 'name' => 'United States Dollar'],
            ['code' => 'EUR', 'name' => 'Euro'],
            ['code' => 'GBP', 'name' => 'British Pound Sterling'],
            ['code' => 'CHF', 'name' => 'Swiss Franc'],
            ['code' => 'SEK', 'name' => 'Swedish Krona'],
            ['code' => 'NOK', 'name' => 'Norwegian Krone'],
            ['code' => 'DKK', 'name' => 'Danish Krone'],
            ['code' => 'PLN', 'name' => 'Polish Złoty'],
            ['code' => 'RUB', 'name' => 'Russian Ruble'],
            ['code' => 'TRY', 'name' => 'Turkish Lira'],
            ['code' => 'CZK', 'name' => 'Czech Koruna'],
            ['code' => 'BYN', 'name' => 'Belarusian Ruble'],
        ];

        foreach ($currencies as $data) {
            $code = $data['code'];

            // Проверка на уникальность валюты по коду
            if (!Currency::where('code', $code)->exists()) {
                $currency = new Currency($data);
                $currency->save();
            }
        }
    }
}
