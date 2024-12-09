<?php

namespace Gptinker\GoogleMerchant\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string generateAccessToken()
 * @method static array fetch()
 * @method static array insert(array $product_data)
 * @method static array update(array $product_data, string $product_id)
 * @method static array delete(string $product_id)
 */

class ProductApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'product-api-service';
    }
}