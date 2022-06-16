[![Latest Stable Version](https://poser.pugx.org/printful/php-api-sdk/v/stable.svg)](https://packagist.org/packages/printful/php-api-sdk)
[![Latest Unstable Version](https://poser.pugx.org/printful/php-api-sdk/v/unstable.svg)](https://packagist.org/packages/printful/php-api-sdk)

# Printful API PHP wrapper

Simple PHP wrapper class for work with Printful API.

API endpoint documentation can be found here: https://www.printful.com/docs

# Installation

Using composer, run `composer require printful/php-api-sdk`

Check out **example** and **test** directories for more specific usage examples.

# OAuth
[OAuth 2.0](https://developers.printful.com/docs/#section/Authentication:~:text=OAuth%202.0%20is%20the%20preferred%20way%20of%20doing%20authorization%20in%20Printful%20API.)
is the preferred way of doing authorization in Printful API. Read more about how to acquire and
use an access token in our docs: https://developers.printful.com/docs/#section/Authentication

In order to use OAuth through the SDK you can set you can pass it in as the second argument to the constructor of the client
```php
$client = new PrintfulApiClient(null, $myOauthToken)
```

You can still use the old store keys
```php
$client = new PrintfulApiClient($storeKey)
```
But theses are being phased out and will no longer work after
September 30th, 2022.

If you pass in both a store key and an OAuth token, the OAuth
token will take precedence.
```php
// $myOauthToken will be used when making requests, not $storeKey
$client = new PrintfulApiClient($storeKey, $myOauthToken)
```
