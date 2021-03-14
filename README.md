The LemonWay API (called Directkit) has two implementations: Directkit**Json2** and Directkit**Xml**. 

The Directkit**Json2** is recommended over the Directkit**Xml** because It is the simplest and the most network-efficient way.

To call the directkit**Json2** in PHP: use the [`curl_init`] to send a POST request (See also the [Postman example](https://documentation.lemonway.com/images/f1a2801937a01dfad047a9c626edcba1.png) in [our documentation](https://documentation.lemonway.com/en/directkit/overview/requests-and-responses/)).

This tutorial show how simple it is.

# How to run

After downloading this project (`git clone`), run:
```
php GetWalletDetailsExample.php
```
Out of the box it will call the `demo` environment. If you have your own test environment. You should fix the configuration in `LemonWay.php`, put your own environment configuration.

Tips: [the Quickest way to get PHP running on a Windows PC](https://github.com/lemonwaysas/php-client-directkit-xml-soap/wiki/Quickest-way-to-get-PHP-running-on-a-Windows-PC)

# Time to play!

In the `GetWalletDetailsExample.php` you succefully called the [`GetWalletDetails`] function to get details information of the wallet `sc`:

```php
require_once "./LemonWay.php";

try {
	$response = callService("GetWalletDetails", array(
					"wallet" => "sc"
				));
	//print the response
	echo json_encode($response, JSON_PRETTY_PRINT);
}
catch (Exception $e) 
{
	echo ($e);
}
```

Following the example, let try to create a new wallet `project001` with the [`RegisterWallet`] function
```php
require_once "./LemonWay.php";
$response = callService("RegisterWallet", array(
				"wallet" => "project001",
				"clientMail" => "peter.pan@email.com",
				"clientFirstName" => "Peter",
				"clientLastName" => "PAN",
				"clientTitle" => "M"
			));
//print the response
echo json_encode($response, JSON_PRETTY_PRINT);
```

Now try to credit the wallet `project001` with a [test card] using the [`MoneyInWebInit`] function:

```php
require_once "./LemonWay.php";
$response = callService("MoneyInWebInit", array(
				"wallet" => "project001",
				"amountTot" => "10.50"
			));
//print the response
echo json_encode($response, JSON_PRETTY_PRINT);
```

You will get a Business Error if the wallet `sc` is 0. In order to make this example working, you will have to

1. Credit the wallet `sc` first or put a reasonable amout of commission in the request 
 * you can credit the wallet sc in your BackOffice (on test environment) or by contacting the LemonWay Staff (on production) 
 * or you can put a reasonable amout of commission in the request. Eg:
```php
require_once "./LemonWay.php";
$response = callService("MoneyInWebInit", array(
				"wallet" => "project001",
				"amountTot" => "10.50",
				"amountCom" => "2.00"
			));
//print the response
echo json_encode($response, JSON_PRETTY_PRINT);
```
Your commercial support will explain more in detail about the commission system.

2. Read the documentation on [`MoneyInWebInit`] to get an idea how it works. Basicly, it will return a token that you will have to combine with the Webkit to get to the payment page.

3. Once you got to the payment page (via the Webkit) you can use one of the [test card]s to finish the payment process.

# See also

You can also try other functions to understand our API:

- [Create a new wallet](https://documentation.lemonway.com/en/directkit/manage-wallets/registerwallet%253A-creating-a-new-wallet/)
- [Create a payment link to credit a wallet](https://documentation.lemonway.com/en/directkit/money-in%253A-credit-a-wallet/by-card/moneyinwebinit%253A-indirect-mode-money-in-by-card-crediting-a-wallet/)
- [Create a payment form to credit a wallet](https://documentation.lemonway.com/en/directkit/money-in%253A-credit-a-wallet/payment-form/)
- [Register an IBAN to the wallet](https://documentation.lemonway.com/en/directkit/money-out%253A-debit-a-wallet-and-credit-a-bank-account/registeriban%253A-add-a-bank-account-(iban-format)-to-a-payment-account-for-money-outs/)
- [Transfer money from wallet to a bank account](https://documentation.lemonway.com/en/directkit/money-out%253A-debit-a-wallet-and-credit-a-bank-account/moneyout%253A-external-fund-transfer-from-a-wallet-to-a-bank-account/)
- [Transfer money from wallet to other wallet](https://documentation.lemonway.com/en/directkit/p2p%253A-transfer-between-wallets/sendpayment%253A-on-us-payment-between-wallets/)

# Note

* The code only use PHP basic to stay framework-neutral. It only show you how easy to access to our service. In real project you might change it a litte, for example: wrap the `callService` in a service class in your Laravel project, or make a Symfony component for yourself.
* A good practices is to log any request / response (with Monolog for example) to our service in Development mode.


[`curl_init`]: http://php.net/manual/en/function.curl-init.php
[`SoapClient`]: http://php.net/manual/en/class.soapclient.php
[SoapClient]: https://github.com/lemonwaysas/php-client-directkit-xml-soap
[SoapClient SDK]: https://github.com/lemonwaysas/php-client-directkit-xml-soap-sdk
[LemonWay SDK]: https://github.com/lemonwaysas/php-client-directkit-xml
[LemonWay API documentation]: http://documentation.lemonway.com/
[`MoneyInWebInit`]: https://documentation.lemonway.com/en/directkit/money-in%253A-credit-a-wallet/by-card/moneyinwebinit%253A-indirect-mode-money-in-by-card-crediting-a-wallet/
[`GetWalletDetails`]: https://documentation.lemonway.com/en/directkit/manage-wallets/getwalletdetails%253A-get-detailed-wallet-data/
[`RegisterWallet`]: https://documentation.lemonway.com/en/directkit/manage-wallets/registerwallet%253A-creating-a-new-wallet/
[test card]: https://documentation.lemonway.com/en/introduction/test-environment-and-default-accounts/
