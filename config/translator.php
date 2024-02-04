<?php declare(strict_types=1);

use Translator\Framework\LaravelConfigLoader;
use Translator\Infra\LaravelJsonTranslationRepository;

return [
    'languages' => ["fa","ru","ar","fr"],
    'directories' => [
        app_path(),
        resource_path('views'),
    ],
    'output' => resource_path('lang'),
    'extensions' => ['php'],
    'container' => [
        'config_loader' => LaravelConfigLoader::class,
        'translation_repository' => LaravelJsonTranslationRepository::class,
    ],
];
