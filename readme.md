# Zend Expressive config manager

## Installation

### Composer

The preferred way to install this extension is through [Composer](http://getcomposer.org/).

Either run

```
php composer.phar require zelenin/zend-expressive-config "~0.0.2"
```

or add

```
"zelenin/zend-expressive-config": "~0.0.2"
```

to the require section of your ```composer.json```

## Usage

```php
<?php

use Zelenin\FooModule\FooModuleConfig;
use Zelenin\Zend\Expressive\Config\Manager\Config;
use Zelenin\Zend\Expressive\Config\Provider\ArrayProvider;
use Zelenin\Zend\Expressive\Config\Provider\CacheProvider;
use Zelenin\Zend\Expressive\Config\Provider\PhpProvider;

$dev = true; // environment variable

$manager = new Config(
    [
        new PhpProvider(__DIR__ . '/../config/autoload/{{,*.}global,{,*.}local}.php'),
        new ArrayProvider(['foo' => 'bar']),
        new FooModuleConfig()
    ],
    $dev ? null : new CacheProvider(__DIR__ . '/../data/cache/app-config.php')
);
return $manager->getConfig();
```

Module config example:

```php
namespace Zelenin\FooModule;

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
