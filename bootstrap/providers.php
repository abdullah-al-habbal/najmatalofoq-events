<?php
// filePath: bootstrap\providers.php
return [
    Modules\Shared\Infrastructure\Providers\PsrHttpServiceProvider::class,
    Modules\IAM\Infrastructure\Providers\IAMServiceProvider::class,
    App\Providers\DocumentationServiceProvider::class,
    Modules\Shared\Infrastructure\Providers\SharedServiceProvider::class,
];

