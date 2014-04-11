php-console-bundle
==================

Symfony PHP console bundle

Component
---------

https://github.com/barbushin/php-console

Google Chrome extension
-----------------------

https://chrome.google.com/webstore/detail/php-console/nfhmhhlpfleoednkpnnnkolmclajemef

Install
------------

https://packagist.org/packages/vitre/php-console-bundle

```bash
composer require vitre/php-console-bundle dev-master
```

Configuration
-------------

```yml
# app/config/config.yml

vitre_php_console:
    enabled: true
    source_base_path: %kernel.root_dir%
    encoding: utf-8
    ip: [192.168.*.*]
    password: pass
    ssl_only: false
    handle:
        errors: true
        exceptions: true
        forward: true
    auto_log:
        - $_SERVER
        - $_SESSION
        - $_REQUEST
        - demo_logger
    eval_dispatcher:
        enabled: true
        shared:
            - $_POST
        open_base_dirs:
            [%kernel.root_dir%]

```