# External Call Blocker Library
[![Build Status](https://img.shields.io/travis/dafiti/external-call-blocker/master.svg?style=flat-square)](https://travis-ci.org/dafiti/external-call-blocker)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/dafiti/external-call-blocker/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/dafiti/external-call-blocker/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/dafiti/external-call-blocker/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/dafiti/external-call-blocker/?branch=master)
[![HHVM](https://img.shields.io/hhvm/dafiti/external-call-blocker.svg)](https://travis-ci.org/dafiti/external-call-blocker)
[![Latest Stable Version](https://img.shields.io/packagist/v/dafiti/external-call-blocker.svg?style=flat-square)](https://packagist.org/packages/dafiti/external-call-blocker)
[![Total Downloads](https://img.shields.io/packagist/dt/dafiti/external-call-blocker.svg?style=flat-square)](https://packagist.org/packages/dafiti/external-call-blocker)
[![License](https://img.shields.io/packagist/l/dafiti/external-call-blocker.svg?style=flat-square)](https://packagist.org/packages/dafiti/external-call-blocker)

## Instalation
The package is available on [Packagist](http://packagist.org/packages/dafiti/external-call-blocker).
Autoloading is [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) compatible.

```json
{
    "require": {
        "dafiti/external-call-blocker": "dev-master"
    }
}
```


## Usage
---
##### Allowing calls
-
```php
use Dafiti\Blocker;

$domains = [".dafiti.com.br", ".dafitisports.com.br", ".grendene.com.br"];
$_SERVER["HTTP_REFERER"] = "http://www.dafitisports.com.br/calcados";
$blocker = new Blocker\Request($domains);

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
$blocker->isAllowed($request); // TRUE

```

##### Blocking external calls
-
```php
use Dafiti\Blocker;

$domains = [".dafiti.com.br", ".dafitisports.com.br", ".grendene.com.br"];
$_SERVER["HTTP_REFERER"] = "http://www.anotherurl.com.br/calcados";
$blocker = new Blocker\Request($domains);

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
$blocker->isAllowed($request); // FALSE

// create and send a HTTP Response with 412 Status Code - Pre Conditional Failed
$blocker->sendBlockedResponse(); 

```

## License

MIT License
