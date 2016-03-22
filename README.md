vitre-php-console-bundle
========================

Symfony PHP console bundle

[![Version](http://img.shields.io/packagist/v/vitre/php-console-bundle.svg)](https://packagist.org/packages/vitre/php-console-bundle)
[![Downloads](http://img.shields.io/packagist/dm/vitre/php-console-bundle.svg)](https://packagist.org/packages/vitre/php-console-bundle) 
[![Licence](http://img.shields.io/packagist/l/vitre/php-console-bundle.svg)](https://github.com/Vitre/php-console-bundle/blob/master/LICENSE)


Drivers
-------

### php_console

 - https://github.com/barbushin/php-console
 - https://packagist.org/packages/php-console/php-console
 - https://chrome.google.com/webstore/detail/php-console/nfhmhhlpfleoednkpnnnkolmclajemef

### chrome_logger

 - https://github.com/ccampbell/chromephp
 - https://packagist.org/packages/ccampbell/chromephp
 - https://chrome.google.com/extensions/detail/noaneddfkdjfnfdakjjmocngnfkfehhd


Install
------------

### Composer

https://packagist.org/packages/vitre/php-console-bundle

```bash
composer require vitre/php-console-bundle dev-master
```

### Symfony

AppKernel.php

```php
new Vitre\PhpConsoleBundle\VitrePhpConsoleBundle(),
```


Configuration
-------------

```yml
# app/config/config.yml

vitre_php_console:
    enabled: true
    driver: php_console
    source_base_path: %kernel.root_dir%
    encoding: utf-8

    # not implemented for chrome logger
    ip: [192.168.*.*]
    password: pass
    ssl_only: false
    handle:
        errors: true
        exceptions: true
        forward: true

```

Logging
-------

```php
$this->getContainer()->get('vitre_php_console')->log($var);
```

Temporary file
--------------
%kernel.root_dir%/cache/%kernel.environment%/vitre_php_console.data
