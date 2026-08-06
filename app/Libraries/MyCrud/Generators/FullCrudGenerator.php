<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

/**
 * Wrapper di compatibilità: forza l'architettura Full e delega al coordinatore.
 */
final class FullCrudGenerator
{
    public function generate(array $config, bool $force = false): array
    {
        $config['architecture'] = 'full';

        return (new CrudArchitectureGenerator())->generate($config, $force);
    }
}
