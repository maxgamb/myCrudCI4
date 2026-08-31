<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Core;

use App\Libraries\MyCrud\Analysis\DomainGuidanceInjector;
use App\Libraries\MyCrud\Generators\CrudArchitectureGenerator;

/** Facade del generatore progressivo Basic, Standard e Full. */
final class CrudGeneratorService
{
    public function generate(array $config, bool $force = false): array
    {
        $result = (new CrudArchitectureGenerator())->generate($config, $force);

        (new DomainGuidanceInjector())->inject(
            $config,
            (array) ($result['files'] ?? [])
        );

        return $result;
    }
}
