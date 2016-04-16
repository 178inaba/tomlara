# tomlara

package for using the config file of [toml](https://github.com/toml-lang/toml) in [laravel](https://laravel.com/).

## install

``` bash
$ composer require 178inaba/tomlara
```

## how to use

``` php
<?php

//namespace App\Console;
namespace App\Http;

//use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

//class Kernel extends ConsoleKernel
class Kernel extends HttpKernel
{
    protected function bootstrappers()
    {
        $this->bootstrappers[] = 'Inaba\Tomlara';
        return $this->bootstrappers;
    }
}
```

## licence

MIT
