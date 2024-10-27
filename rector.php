<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector;
use Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector;
use Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictSetUpRector;

/**
 * @see https://github.com/rectorphp/rector/blob/main/docs/rector_rules_overview.md
 */
return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/config',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $rectorConfig->cacheClass(FileCacheStorage::class);
    $rectorConfig->cacheDirectory('./.cache/rector');

    // register a single rule
    $rectorConfig->rules([
        InlineConstructorDefaultToPropertyRector::class,
        ChangeIfElseValueAssignToEarlyReturnRector::class,
        RemoveUnusedVariableInCatchRector::class,
        TypedPropertyFromStrictSetUpRector::class,
        ReadOnlyPropertyRector::class,
        ChangeSwitchToMatchRector::class,
        FinalPrivateToPrivateVisibilityRector::class,
    ]);

    // define sets of rules
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_81,
        // \RectorLaravel\Set\LaravelLevelSetList::UP_TO_LARAVEL_100,
    ]);

    $rectorConfig->skip([
        ClosureToArrowFunctionRector::class,
    ]);
};
