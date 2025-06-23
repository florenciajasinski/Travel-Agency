<?php

declare(strict_types=1);

namespace Lightit;

use Illuminate\Foundation\Application as LaravelApplication;

class Application extends LaravelApplication
{
    protected $namespace = 'Lightit\\';

    public function __construct($basePath = null)
    {
        parent::__construct($basePath);
        $this->useAppPath(
            $basePath . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR
        );
    }
}
