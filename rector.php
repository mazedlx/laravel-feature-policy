<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Set\ValueObject\LevelSetList;
use RectorLaravel\Set\LaravelLevelSetList;

/**
 * @see https://github.com/rectorphp/rector/blob/main/docs/rector_rules_overview.md
 */
return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/config',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    // register a single rule
    $rectorConfig->rules([
        InlineConstructorDefaultToPropertyRector::class,
        ChangeAndIfToEarlyReturnRector::class,
        \Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector::class,
        \Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector::class,
        \Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class,
        \Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictSetUpRector::class,
    ]);

    // define sets of rules
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_74,
        LaravelLevelSetList::UP_TO_LARAVEL_90,
    ]);

//    $rectorConfig->rule(\Rector\Php81\Rector\Property\ReadOnlyPropertyRector::class);
//    $rectorConfig->rule(\Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector::class);
//    $rectorConfig->rule(\Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector::class);

    $rectorConfig->skip([
        ClosureToArrowFunctionRector::class,
    ]);
};
