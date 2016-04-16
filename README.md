# tomlara

[![Latest Stable Version](https://poser.pugx.org/178inaba/tomlara/v/stable)](https://packagist.org/packages/178inaba/tomlara)
[![Total Downloads](https://poser.pugx.org/178inaba/tomlara/downloads)](https://packagist.org/packages/178inaba/tomlara)
[![Latest Unstable Version](https://poser.pugx.org/178inaba/tomlara/v/unstable)](https://packagist.org/packages/178inaba/tomlara)
[![License](https://poser.pugx.org/178inaba/tomlara/license)](https://packagist.org/packages/178inaba/tomlara)

package for using the config file of [toml](https://github.com/toml-lang/toml) in [laravel](https://laravel.com/).

## install

``` bash
$ composer require 178inaba/tomlara
```

## how to use

add `bootstrappers()` method for `app/Http/Kernel.php` or `app/Console/Kernel.php`.

``` php
<?php

//namespace App\Console;
namespace App\Http;

//use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

//class Kernel extends ConsoleKernel
class Kernel extends HttpKernel
{

    // ...

    protected function bootstrappers()
    {
        $this->bootstrappers[] = 'Inaba\Tomlara';
        return $this->bootstrappers;
    }
}
```

## licence

MIT
