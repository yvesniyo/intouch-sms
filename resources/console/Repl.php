<?php

/**
 * This file is part of yvesniyo/intouch-sms
 *
 * yvesniyo/intouch-sms is free and unencumbered software released
 * into the public domain. For more information, please view the
 * UNLICENSE file that was distributed with this source code.
 *
 * @license https://unlicense.org The Unlicense
 */

declare(strict_types=1);

namespace Yvesniyo\Console;

use Psy\Configuration;
use Psy\Shell;

/**
 * A REPL (read-eval-print loop) for use with development
 *
 * This REPL uses PsySH. To use it, enter `./bin/repl` at your command prompt.
 *
 * @link https://psysh.org PsySH
 */
class Repl
{
    public static function start(): void
    {
        static::loadEnvironment();

        unset($_SERVER['argv']);

        $config = new Configuration([
            'startupMessage' => '<info>'
                . 'Welcome to the REPL for yvesniyo/intouch-sms!'
                . '</info>',
            'colorMode' => Configuration::COLOR_MODE_FORCED,
            'updateCheck' => 'never',
            'useBracketedPaste' => true,
        ]);

        $shell = new Shell($config);
        $shell->setScopeVariables(self::getScopeVariables());
        $shell->run();
    }

    private static function loadEnvironment(): void
    {
        // Set up any configuration or bootstrapping of the environment here.
    }

    /**
     * @return mixed[]
     */
    private static function getScopeVariables(): array
    {
        return [];
    }
}
