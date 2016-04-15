<?php

namespace Inaba\Tomlara;

use Yosymfony\Toml\Toml;
use Illuminate\Config\Repository;
use Symfony\Component\Finder\Finder;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Config\Repository as RepositoryContract;

class Tomlara extends LoadConfiguration
{
    /**
     * load the configuration items from toml files.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Contracts\Config\Repository  $repository
     * @return void
     */
    protected function loadConfigurationFiles(Application $app, RepositoryContract $repository)
    {
        foreach ($this->getConfigurationFiles($app) as $key => $path) {
            $config->set($key, $this->parseToml($path));
        }
    }

    /**
     * get toml configuration files for the application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return array
     */
    protected function getConfigurationFiles(Application $app)
    {
        $files = [];

        $configPath = realpath($app->configPath());

        foreach (Finder::create()->files()->name('*.toml')->in($configPath) as $file) {
            $nesting = $this->getConfigurationNesting($file, $configPath);

            $files[$nesting.basename($file->getRealPath(), '.toml')] = $file->getRealPath();
        }

        return $files;
    }

    /**
     * parse toml
     *
     * @param  string  $file
     * @return array
     */
    protected function parseToml($file)
    {
        $cacheDir = sprintf('%s/framework/cache/tomlara/', storage_path());
        $cacheFile = $cacheDir . basename($file) . '.cache.php';

        if (@filemtime($cacheFile) < filemtime($file)) {
            $content = null === ($toml = Toml::Parse($file)) ? [] : $toml;
            array_walk_recursive($content, [$this, 'parseValues']);

            if (! file_exists($cacheDir)) {
                @mkdir($cacheDir, 0644);
            }

            file_put_contents($cacheFile, '<?php' . PHP_EOL . PHP_EOL . 'return ' . var_export($content, true) . ';');
        } else {
            $content = require $cacheFile;
        }

        return $content;
    }

    /**
     * parse func
     *
     * @param  mixed  $value
     * @return void
     */
    protected function parseFunc(&$value)
    {
        if (! is_string($value)) {
            return;
        }

        preg_match_all('/%([a-zA-Z_]+)(?::(.*))?%/', $value, $matches);

        if (empty(array_shift($matches))) {
            return;
        }

        $function = current(array_shift($matches));

        if (! function_exists($function)) {
            return;
        }

        $args = current(array_shift($matches));
        $value = call_user_func_array($function, explode(',', $args));
    }
}
