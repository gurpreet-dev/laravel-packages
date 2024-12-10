<?php

use Gptinker\GoogleMerchant\Facades\ProductApi;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome back');
});

Route::group(['prefix' => 'gcheck'], function () {
    Route::get('list', function () {
        $res = ProductApi::fetch();
        dd($res);
    });

    Route::get('add', function () {

        $product_data = [
            // 'offerId' => 'hello-world-123',
            'title' => 'Hello World Product updated 2',
            'description' => 'A description of the Hello World product.',
            'link' => 'https://example.com/product-page',
            'imageLink' => 'https://example.com/product-image.jpg',
            'availability' => 'in stock',
            'condition' => 'new',
            'channel' => 'online',
            'price' => [
                'value' => '40',
                'currency' => 'AED',
            ],
            'brand' => 'Hello World Brand',
            'gtin' => '1234567890456',
            'mpn' => '789012',
        ];

        $res = ProductApi::update($product_data, "hello-world-123");
        dd($res);
    });

    Route::get('delete', function () {
        $res = ProductApi::delete("test-product-1234");
        dd($res);
    });
});
