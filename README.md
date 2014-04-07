php-console-bundle
==================

Symfony PHP console bundle

Component
---------

https://github.com/barbushin/php-console

Google Chrome extension
-----------------------

https://chrome.google.com/webstore/detail/php-console/nfhmhhlpfleoednkpnnnkolmclajemef


Configuration
-------------

```yml
# app/config/config.yml

vitre_php_console:
    enabled: true
    source_base_path: %kernel.root%
    encoding: utf-8
    ip_masks: [192.168.*.*]
    password: 
    ssl_only: false
    handle:
        errors: true
        exceptions: true
        forward: true
    auto_log:
        $_SERVER
        $_SESSION
        $_REQUEST
        site_bundle
    eval_dispatcher:
        enabled: true
        shared:
            post: $_POST
        open_base_dirs:
            []

```