<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'category',
        'price',
        'currency',
        'url',
        'image_url'
    ];

    /**
     * @return string
     */
    public function getCurrencySymbolAttribute (): string
    {
        $currencyCodeToSymbol = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'AUD' => 'A$',
            'CAD' => 'C$',
        ];

        return $currencyCodeToSymbol[$this->currency] ?? $this->currency;
    }
}
