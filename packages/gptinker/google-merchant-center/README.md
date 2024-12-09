# Google Merchant Center APIs for Laravel

## Installation
```bash
composer require gpsin/google-merchant
```

## Setup
##### 1. Add Variable given below to .env file
```php
GOOGLE_MERCHANT_ID="1234567890"
GOOGLE_MERCHANT_TARGET_COUNTRY="AE"
GOOGLE_MERCHANT_CONTENT_LANGUAGE="en"
GOOGLE_MERCHANT_CHANNEL="online"
```
##### 2. Store your credentials JSON file in __storage/json__ folder named __google-merchant-credentials.json__
```bash
storage/json/google-merchant-credentials.json
```
## Usage

```bash
use Gptinker\GoogleMerchant\Facades\ProductApi;
```

#### 1. Fetch Products
```php
$response = ProductApi::fetch();

if($response['status'] == 'success'){
    // Success
}else{
    // Error
}
```

#### 2. Insert Product

The request body contains an instance of [Product](https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product)

```php
$response = ProductApi::insert($product);

if($response['status'] == 'success'){
    // Success
}else{
    // Error
}
```

#### 3. Update Product

The request body contains an instance of [Product](https://developers.google.com/shopping-content/reference/rest/v2.1/products#Product)

```bash
$product_id = Same id used in "offerId" while insertion
```

```php
$response = ProductApi::update($product, $product_id);

if($response['status'] == 'success'){
    // Success
}else{
    // Error
}
```

#### 3. Delete Product

```bash
$product_id = Same id used in "offerId" while insertion
```

```php
$response = ProductApi::delete($product_id);

if($response['status'] == 'success'){
    // Success
}else{
    // Error
}
```