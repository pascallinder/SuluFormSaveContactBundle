# SuluFormSaveContactBundle

**Sulu bundle that integrates a hidden save to contacts field for the [SuluFormBundle](https://github.com/sulu/SuluFormBundle).**

## Installation

This bundle requires PHP 8.2 and Sulu 2.6

1. Open a command console, enter your project directory and run:

```console
composer require linderp/sulu-form-save-contact-bundle
```

If you're **not** using Symfony Flex, you'll also need to add the bundle in your `config/bundles.php` file:

```php
return [
    //...
    Linderp\SuluFormSaveContactBundle\SuluFormSaveContactBundle::class => ['all' => true],
];
```

2. Clear the cache:

```bash
bin/console cache:clear
```
