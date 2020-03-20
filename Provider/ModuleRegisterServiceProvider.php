<?php

namespace DNAFactory\Framework\Provider;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class ModuleRegisterServiceProvider extends \DNAFactory\Core\Provider\ModuleRegisterServiceProvider
{
    public function getBasePath()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..';
    }

    public function getModuleName()
    {
        return 'Framework';
    }
}
