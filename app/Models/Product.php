<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'tags'];

    protected $casts = [
        'tags' => 'array',
    ];

    public static function getProductsWithHighestPrice()
    {
        $products = self::all();
        $maxPrice = null;
        $highestPriceProduct = [];

        foreach ($products as $product) {
            if ($maxPrice === null || $product->price > $maxPrice) {
                $maxPrice = $product->price;
                $highestPriceProduct = [$product];
            } elseif ($product->price == $maxPrice) {
                $highestPriceProduct[] = $product;
            }
        }

        return $highestPriceProduct;
    }

    public static function getMostUsedTagsWithProducts()
    {
        $products = self::all();

        $tagsCount = [];
        $tagsProducts = [];

        foreach ($products as $product) {
            if (isset($product->tags) && is_array($product->tags)) {
                foreach ($product->tags as $tag) {
                    $tagsCount[$tag] = ($tagsCount[$tag] ?? 0) + 1;
                    $tagsProducts[$tag][] = $product;
                }
            }
        }

        if (empty($tagsCount)) {
            return null;
        }

        $mostUsedTag = array_keys($tagsCount, max($tagsCount))[0];

        return [
            'tag' => $mostUsedTag,
            'count' => $tagsCount[$mostUsedTag],
            'products' => $tagsProducts[$mostUsedTag],
        ];
    }
}
