<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

use InvalidArgumentException;

/**
 * Coordina la generazione progressiva delle architetture Basic, Standard e Full.
 *
 * Componenti comuni: Model, Controller web, Validation, Views e Routes.
 * Standard aggiunge Entity e Service. Full aggiunge API, API Validation e OpenAPI.
 */
final class CrudArchitectureGenerator
{
    private const ARCHITECTURES = ['basic', 'standard', 'full'];

    public function generate(array $config, bool $force = false): array
    {
        $config = $this->normalizeConfig($config);
        $architecture = (string) $config['architecture'];

        $result = [
            'table'        => (string) $config['table'],
            'architecture' => $architecture,
            'force'        => $force,
            'files'        => [],
        ];

        // Runtime del sito: librerie condivise dai CRUD generati.
        // Sono indipendenti da myCrudGpt e restano utilizzabili anche se il
        // generatore viene rimosso dall'applicazione a progetto concluso.
        $result['files']['runtime'] = (new RuntimeSupportGenerator())->generate($force);

        if (!empty($config['features']['entity'])) {
            $result['files']['entity'] = (new EntityGenerator())->generate($config, $force);
        }

        $result['files']['model']      = (new ModelGenerator())->generate($config, $force);

        if (!empty($config['features']['service'])) {
            $result['files']['service'] = (new ServiceGenerator())->generate($config, $force);
        }

        $result['files']['validation'] = (new ValidationGenerator())->generate($config, $force);
        $result['files']['language'] = (new LanguageGenerator())->generate($config, $force);
        $result['files']['controller'] = (new ControllerGenerator())->generate($config, $force);

        if (!empty($config['features']['api'])) {
            $result['files']['api_validation'] = (new ApiValidationGenerator())->generate($config, $force);
            $result['files']['api'] = (new ApiGenerator())->generate($config, $force);
            $result['files']['openapi'] = (new OpenApiGenerator())->generate($config, $force);
        }

        $result['files']['views']  = (new ViewGenerator())->generate($config, $force);
        $result['files']['routes'] = (new RouteGenerator())->generate($config, $force);

        return $result;
    }

    private function normalizeConfig(array $config): array
    {
        $architecture = strtolower(trim((string) ($config['architecture'] ?? 'basic')));
        if (!in_array($architecture, self::ARCHITECTURES, true)) {
            throw new InvalidArgumentException('Architettura non valida: ' . $architecture);
        }

        $features = (array) ($config['features'] ?? []);
        $features['entity']        = in_array($architecture, ['standard', 'full'], true);
        $features['service']       = in_array($architecture, ['standard', 'full'], true);
        $features['api']           = $architecture === 'full';
        $features['ajaxList']      = true;
        $features['csvExport']     = true;
        $features['wordExport']    = true;
        $features['datatable']     = false;
        $features['exportButtons'] = true;
        $features['relations']     = array_key_exists('relations', $features)
            ? !empty($features['relations'])
            : true;
        $features['timestamps']    = array_key_exists('timestamps', $features)
            ? !empty($features['timestamps'])
            : true;

        if (empty($config['softDelete']['available']) || !empty($features['readOnly'])) {
            $features['softDeletes'] = false;
        }

        $features['readOnly'] = !empty($features['readOnly']);
        $features['createAllowed'] = array_key_exists('createAllowed', $features)
            ? !empty($features['createAllowed'])
            : !$features['readOnly'];
        $features['writable'] = array_key_exists('writable', $features)
            ? !empty($features['writable'])
            : !$features['readOnly'];
        $features['recordDetail'] = array_key_exists('recordDetail', $features)
            ? !empty($features['recordDetail'])
            : !$features['readOnly'];
        $features['recordActions'] = array_key_exists('recordActions', $features)
            ? !empty($features['recordActions'])
            : $features['recordDetail'];

        $config['architecture'] = $architecture;
        $config['features'] = $features;

        return $config;
    }
}
