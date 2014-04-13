vitre-php-console-bundle
========================

Symfony PHP console bundle


Drivers
-------

### php_conosle

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

    # not implemented
    auto_log:
        - $_SERVER
        - $_SESSION
        - $_REQUEST
        - demo_logger #custom autolog callback

    # not implemented
    eval_dispatcher:
        enabled: true
        shared:
            - $_POST
        open_base_dirs:
            [%kernel.root_dir%]

```

Logging
-------

```php
$this->getContainer()->get('vitre_php_console')->log($var);
```

Temporary file
--------------
/app/tmp/vitre_php_console.data
