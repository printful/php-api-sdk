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

You can create an OAuth enabled APIClient using the following factory method:
```php
...
use Printful\PrintfulApiClient;
... 
$client = PrintfulApiClient::createOauthClient('my-oauth-token')
```

You can still use the old store keys, like this:
```php
...
use Printful\PrintfulApiClient;
... 
$client = PrintfulApiClient::createLegacyStoreKeyClient('my-legacy-store-key')
```
or, by using the constructor like this:
```php
$client = new PrintfulApiClient($storeKey)
```
However, please note that legacy keys will be phased out on September 30th, 2022.
