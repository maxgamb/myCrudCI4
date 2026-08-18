<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

/**
 * Generates the custom Service trait only once.
 *
 * Il file finale app/Services/Extensions/<Service>Extension.php appartiene allo
 * sviluppatore e non deve mai essere sovrascritto da myCrudCI4.
 */
final class ServiceExtensionGenerator
{
    use GeneratorTrait;

    public function generate(array $config): array
    {
        if (empty($config['features']['writable'])) {
            return [
                'status' => 'skipped',
                'reason' => 'not_writable',
                'path'   => '',
            ];
        }

        $serviceClass = (string) $config['classes']['service'];
        $extensionClass = $serviceClass . 'Extension';
        /** @var \Config\MyCrud $settings */
        $settings = config('MyCrud');
        $customRoot = rtrim($settings->serviceExtensionPath, DIRECTORY_SEPARATOR);
        $finalPath = $customRoot . DIRECTORY_SEPARATOR . $extensionClass . '.php';

        // Il file Extension vive direttamente nell'area persistente custom e
        // non viene mai scritto sotto app/Generated/.
        if (is_file($finalPath)) {
            return [
                'status' => 'skipped',
                'reason' => 'protected_custom_exists',
                'path'   => $finalPath,
            ];
        }

        $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\Services\Extensions;

/**
 * CUSTOM SERVICE EXTENSION
 *
 * Questo file viene creato da myCrudCI4 solo se manca e NON viene mai
 * sovrascritto, neppure usando "Sovrascrivi file esistenti".
 *
 * Inserisci qui la logica applicativa specifica che non deve andare persa
 * quando il CRUD viene rigenerated. Mantieni le query nel Model e usa questo
 * trait per orchestrazione, normalizzazioni e side-effect applicativi.
 */
trait {$extensionClass}
{
    /**
     * Executed before creation.
     * Puoi modificare i dati e restituire l'array aggiornato.
     *
     * @param array<string, mixed> \$data
     * @return array<string, mixed>
     */
    protected function beforeCreate(array \$data): array
    {
        // CUSTOM: logica prima del create.
        // Esempio: return \$this->exampleApplyBusinessRule(\$data);
        return \$data;
    }

    // ---------------------------------------------------------------------
    // CUSTOMIZATION EXAMPLE (disabled by default)
    // ---------------------------------------------------------------------
    // Uncomment, rename and adapt this helper only when a real business rule
    // requires it, then call it explicitly from beforeCreate/beforeUpdate.
    // Keep SQL/query composition in the Model. For cross-resource writes use
    // a concrete generated Service explicitly, never a runtime resolver.
    //
    // Example of an explicit cross-resource write:
    // return (new CustomerService())->createRelated(\$payload);
    //
    // private function exampleApplyBusinessRule(array \$data): array
    // {
    //     // EXAMPLE ONLY: replace "business_field" with a real field.
    //     if (array_key_exists('business_field', \$data) && is_string(\$data['business_field'])) {
    //         \$data['business_field'] = trim(\$data['business_field']);
    //     }
    //
    //     return \$data;
    // }

    /**
     * Eseguito dopo che il record è stato creato con successo.
     *
     * @param array<string, mixed> \$data
     */
    protected function afterCreate(int|string \$id, array \$data): void
    {
        // CUSTOM: logica dopo il create.
    }

    /**
     * Executed before update.
     * Puoi modificare i dati e restituire l'array aggiornato.
     *
     * @param array<string, mixed> \$data
     * @return array<string, mixed>
     */
    protected function beforeUpdate(int|string \$id, array \$data): array
    {
        // CUSTOM: logica prima dell'update.
        return \$data;
    }

    /**
     * Eseguito dopo che il record è stato aggiornato con successo.
     *
     * @param array<string, mixed> \$data
     */
    protected function afterUpdate(int|string \$id, array \$data): void
    {
        // CUSTOM: logica dopo l'update.
    }

    /** Executed before record deletion. */
    protected function beforeDelete(int|string \$id): void
    {
        // CUSTOM: logica prima del delete.
    }

    /** Eseguito dopo che il record è stato eliminato con successo. */
    protected function afterDelete(int|string \$id): void
    {
        // CUSTOM: logica dopo il delete.
    }
}

PHP;

        $dir = dirname($finalPath);
        if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
            throw new \RuntimeException('Impossibile creare la directory custom Service Extension: ' . $dir);
        }

        // Create-only by definition: no force option may overwrite this file.
        if (file_put_contents($finalPath, $content, LOCK_EX) === false) {
            throw new \RuntimeException('Impossibile scrivere il Service Extension custom: ' . $finalPath);
        }

        return [
            'status' => 'created',
            'reason' => 'custom_created',
            'path'   => $finalPath,
            'protected' => true,
        ];
    }
}
