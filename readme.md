# Zend Expressive config manager

## Installation

### Composer

The preferred way to install this extension is through [Composer](http://getcomposer.org/).

Either run

```
php composer.phar require zelenin/zend-expressive-config "~1.0.0"
```

or add

```
"zelenin/zend-expressive-config": "~1.0.0"
```

to the require section of your ```composer.json```

## Usage

```php
<?php

use Zelenin\FooModule\Config\FooModuleConfig;
use Zelenin\Zend\Expressive\Config\ConfigManager;
use Zelenin\Zend\Expressive\Config\Provider\ArrayProvider;
use Zelenin\Zend\Expressive\Config\Provider\CacheProvider;
use Zelenin\Zend\Expressive\Config\Provider\PhpProvider;

$productionMode = true; // environment variable

$providers =  [
    new PhpProvider(__DIR__ . '/../config/autoload/{{,*.}global,{,*.}local}.php'),
    new ArrayProvider(['foo' => 'bar']),
    new FooModuleConfig(),
];

if ($productionMode) {
    $providers = [new CacheProvider(__DIR__ . '/../data/cache/app-config.php', $providers)];
}

$manager = new ConfigManager($providers);
$config = $manager->getConfig();
```

Module config example:

```php
namespace Zelenin\FooModule\Config;

use Zelenin\Zend\Expressive\Config\Provider\ModuleConfigProvider;

final class FooModuleConfig extends ModuleConfigProvider
{
    /**
     * @return array
     */
    public function getConfig()
    {
        return [
            'foo' => 'bar'
        ];

        // or

        return require_once 'fooModuleConfig.php';

        // or

        return (new PhpProvider(__DIR__ . '/config/*.php'))->getConfig();
    }
}
```

## Author

[Aleksandr Zelenin](https://github.com/zelenin/), e-mail: [aleksandr@zelenin.me](mailto:aleksandr@zelenin.me)
