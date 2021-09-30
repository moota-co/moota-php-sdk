Moota-PHP-Sdk
===============

[Moota.co](https://moota.co) :heart: PHP!

This is the Official PHP wrapper/library for Moota API V2, that is compatible with Composer. Visit [https://moota.co](https://moota.co) for more information about the product.

## 1. Installation

### 1.a Composer Installation

If you are using [Composer](https://getcomposer.org), you can install via composer CLI:

```
composer require moota-co/moota-php-sdk
```

**or**

add this require line to your `composer.json` file:

```json
{
    "require": {
        "moota-co/moota-php-sdk": "1.*"
    }
}
```
and run `composer install` on your terminal.

> **Note:** If you are using Laravel framework, in [some](https://laracasts.com/discuss/channels/general-discussion/using-non-laravel-composer-package-with-laravel?page=1#reply=461608) [case](https://stackoverflow.com/a/23675376) you also need to run `composer dumpautoload`

### 1.b Manual Instalation
If you are not using Composer, you can [clone](https://github.com/moota-co/moota-php-sdk) this repository.

Then you should require/autoload `Mutation.php` of etc class file on your code.

```php
require __DIR__ . '/../vendor/autoload.php';

// my code goes here
```
## 2. How to Use

### 2.1 General Settings

```php
// Set your API V2 Server Key 
\Moota\Moota\Config::$ACCESS_TOKEN = '<your server key>';
```

### 2.2 Choose Class Method
#### 2.2.1 Authentication

```php

$auth = new \Moota\Moota\Domain\Auth();
try {
    $getSecretToken = $auth->login(
        new \Moota\Moota\DTO\Auth\LoginData('<email>', '<password>', new \Moota\Moota\DTO\Auth\ScopesData(true))
    );
    // set to \Moota\Moota\Config::$ACCESS_TOKEN = $getSecretToken['access_token'];
} catch (\Moota\Moota\Exception\MootaException $exception) {
    // handling fail authentication
}
```

#### Destroy Auth Token
```php

$getSecretToken = new \Moota\Moota\Domain\Auth();
$getSecretToken->logout();
```

#### 2.2.2 Bank Account
```php
$bank_account = new \Moota\Moota\Domain\BankAccount();
```
```php
// store bank account
try {
    $bank_account->storeBankAccount(
        new \Moota\Moota\DTO\BankAccount\BankAccountStoreData(
             '<corporate_id>', 
             '<bank_type>',
             '<username>',
             '<password>',
             '<name_holder>',
             '<account_number>',
        )
    );
 } catch (\Moota\Moota\Exception\MootaException $exception) {
    print_r($exception->getPharseErrors());
 }
```
body parameter storeBankAccount() reference [here][src/DTO/BankAccount/BankAccountStoreData.php]
```php
// update bank account
try {
    $bank_account->updateBankAccount(
        new \Moota\Moota\DTO\BankAccount\BankAccountUpdateData
            '<bank_id>',
             '<corporate_id>', 
             '<bank_type>',
             '<username>',
             '<password>',
             '<name_holder>',
             '<account_number>',
        )
    );
 } catch (\Moota\Moota\Exception\MootaException $exception) {
    print_r($exception->getPharseErrors());
 }
```
body parameter updateBankAccount() reference [here][src/DTO/BankAccount/BankAccountUpdateData.php]
```php
// get list bank account
try {
    $bank_account->getBankList();
 } catch (\Moota\Moota\Exception\MootaException $exception) {
    print_r($exception->getPharseErrors());
 }
```
```php
// can't wait for new mutation data use method refresh mutation 
try {
    $bank_account->refreshMutation('<bank_id>');
 } catch (\Moota\Moota\Exception\MootaException $exception) {
    print_r($exception->getPharseErrors());
 }
```
```php
// want to remove bank account from moota ?
try {
    $bank_account->destroyBankAccount('<bank_id>');
 } catch (\Moota\Moota\Exception\MootaException $exception) {
    print_r($exception->getPharseErrors());
 }
```
```php
// want to activate my wallet account ovo or gojek 
try {
    $otp_code = $bank_account->bankEwalletRequestOTPCode('<bank_id>');
    
    $bank_account->bankEwalletVerificationOTPCode(
        new \Moota\Moota\DTO\BankAccount\BankAccountEwalletOtpVerification('<bank_id>', '<$otp_code>')
    );
 } catch (\Moota\Moota\Exception\MootaException $exception) {
    print_r($exception->getPharseErrors());
 }
```