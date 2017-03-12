The LemonWay API (called Directkit) has two implementations: Directkit**Json2** and Directkit**Xml**. 

The Directkit**Json2** is recommended over the Directkit**Xml** because It is the simplest and the most network-efficient way.

To call the directkit**Json2** in PHP: use the [`curl_init`] to send a POST request. 

This tutorial show how simple it is.

# Sample codes

```php
require_once "./LemonWay.php";

try {
	$response = callService("GetWalletDetails", array(
	            "wallet" => "sc"
	        ));
	echo json_encode($response, JSON_PRETTY_PRINT);
}
catch (Exception $e) 
{
	echo ($e);
}
```
See also: [LemonWay API documentation](http://documentation.lemonway.fr/) / method [`GetWalletDetails`](http://documentation.lemonway.fr/api-en/directkit/manage-wallets/getwalletdetails-getting-detailed-wallet-data)

# How to run

After downloading this project (`git clone`), run:
```
php GetWalletDetails.php 
```
Out of the box it will call the `demo` environment. If you have your own test environment. You should fix the configuration in `LemonWay.php`, put your own environment configuration.

# Note

* The code only use PHP basic to stay framework-neutral. It only show you how easy to access to our service. In real project you might change it a litte, for example: wrap the `callService` in a service class in your Laravel project, or make a Symfony component for yourself.
* A good practices is to log any request / response (with Monolog for example) to our service in Development mode.

# Time to play!

The example is only the basic, you can also play with our API by calling other services. For example:
- [Create a new wallet](http://documentation.lemonway.fr/api-en/directkit/manage-wallets/registerwallet-creating-a-new-wallet)
- [Create a payment link to credit a wallet](http://documentation.lemonway.fr/api-en/directkit/money-in-credit-a-wallet/by-card/moneyinwebinit-indirect-mode-money-in-by-card-crediting-a-wallet)
- [Credit the wallet without 3D secure](http://documentation.lemonway.fr/api-en/directkit/money-in-credit-a-wallet/by-card/moneyin-credit-a-wallet-with-a-non-3d-secure-card-payment)
- [Credit the wallet with 3D secure](http://documentation.lemonway.fr/api-en/directkit/money-in-credit-a-wallet/by-card/moneyin3dinit-direct-mode-3d-secure-payment-init-to-credit-a-wallet)
- [Create a payment form to credit a wallet](http://documentation.lemonway.fr/api-en/directkit/money-in-credit-a-wallet/payment-form)
- [Register a Credit card to the wallet](http://documentation.lemonway.fr/api-en/directkit/money-in-credit-a-wallet/by-card/registercard-linking-a-card-number-to-a-wallet-for-one-click-payment-or-rebill)
- [Register an IBAN to the wallet](http://documentation.lemonway.fr/api-en/directkit/money-out-debit-a-wallet-and-credit-a-bank-account/registeriban-link-an-iban-to-a-wallet)
- [Transfer money from wallet to a bank account](http://documentation.lemonway.fr/api-en/directkit/money-out-debit-a-wallet-and-credit-a-bank-account/moneyout-external-fund-transfer-from-a-wallet-to-a-bank-account)
- [Transfer money from wallet to other wallet](http://documentation.lemonway.fr/api-en/directkit/p2p-transfer-between-wallets/sendpayment-on-us-payment-between-wallets)



[`curl_init`]: http://php.net/manual/en/function.curl-init.php
[`SoapClient`]: http://php.net/manual/en/class.soapclient.php
[SoapClient]: https://github.com/lemonwaysas/php-client-directkit-xml-soap
[SoapClient SDK]: https://github.com/lemonwaysas/php-client-directkit-xml-soap-sdk
[LemonWay SDK]: https://github.com/lemonwaysas/php-client-directkit-xml
