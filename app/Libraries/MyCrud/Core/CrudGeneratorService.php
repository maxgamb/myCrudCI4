<?php

namespace App\Libraries\MyCrud\Core;

use App\Libraries\MyCrud\Generators\ApiGenerator;
use App\Libraries\MyCrud\Generators\ControllerGenerator;
use App\Libraries\MyCrud\Generators\EntityGenerator;
use App\Libraries\MyCrud\Generators\ModelGenerator;
use App\Libraries\MyCrud\Generators\OpenApiGenerator;
use App\Libraries\MyCrud\Generators\RouteGenerator;
use App\Libraries\MyCrud\Generators\ServiceGenerator;
use App\Libraries\MyCrud\Generators\ValidationGenerator;
use App\Libraries\MyCrud\Generators\ViewGenerator;
use InvalidArgumentException;

class CrudGeneratorService
{
    public function generate(array $config, bool $force = false): array
    {
        $architecture = $config['architecture'] ?? 'standard';

        if (!in_array($architecture, ['basic', 'standard', 'full'], true)) {
            throw new InvalidArgumentException(
                'Architettura non valida: ' . $architecture
            );
        }

        $result = [
            'table'        => $config['table'],
            'architecture' => $architecture,
            'force'        => $force,
            'files'        => [],
        ];

        if (!empty($config['features']['entity'])) {
            $result['files']['entity'] = (new EntityGenerator())->generate($config, $force);
        }

        $result['files']['model'] = (new ModelGenerator())->generate($config, $force);

        if (!empty($config['features']['service'])) {
            $result['files']['service'] = (new ServiceGenerator())->generate($config, $force);
        }

        $result['files']['validation'] = (new ValidationGenerator())->generate($config, $force);
        $result['files']['controller'] = (new ControllerGenerator())->generate($config, $force);

        if (!empty($config['features']['api'])) {
            $result['files']['api'] = (new ApiGenerator())->generate($config, $force);
            $result['files']['openapi'] = (new OpenApiGenerator())->generate($config, $force);
        }

        $result['files']['views']  = (new ViewGenerator())->generate($config, $force);
        $result['files']['routes'] = (new RouteGenerator())->generate($config, $force);

        return $result;
    }
}
