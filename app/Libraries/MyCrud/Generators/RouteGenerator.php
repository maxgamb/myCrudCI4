<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

final class RouteGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $table = (string) $config['table'];
        $controller = (string) $config['classes']['controller'];
        $api = (string) $config['classes']['api'];
        $apiEnabled = !empty($config['features']['api']);
        $apiCaps = (array) ($config['apiCapabilities'] ?? []);
        $apiList = $apiEnabled && !empty($apiCaps['list']);
        $apiRead = $apiEnabled && !empty($apiCaps['read']);
        $apiCreate = $apiEnabled && !empty($apiCaps['create']);
        $apiUpdate = $apiEnabled && !empty($apiCaps['update']);
        $apiDelete = $apiEnabled && !empty($apiCaps['delete']);
        $apiTrash = $apiEnabled && !empty($apiCaps['trash']);
        $apiRestore = $apiEnabled && !empty($apiCaps['restore']);
        $apiForceDelete = $apiEnabled && !empty($apiCaps['forceDelete']);
        $crudSecurity = (array) ($config['crudSecurity'] ?? []);
        $crudAuth = (string) ($crudSecurity['auth'] ?? 'none');
        $crudPermissions = (array) ($crudSecurity['permissions'] ?? []);
        $shieldSession = $crudAuth === 'shield_session';
        $apiSecurity = (array) ($config['apiSecurity'] ?? []);
        $apiAuth = (string) ($apiSecurity['auth'] ?? 'none');
        $apiPermissions = (array) ($apiSecurity['permissions'] ?? []);
        $shieldTokens = $apiEnabled && $apiAuth === 'shield_tokens';
        $createAllowed = !empty($config['features']['createAllowed']);
        $writable = !empty($config['features']['writable']);
        $recordDetail = !empty($config['features']['recordDetail']);
        $isView = !empty($config['isView']);
        $hasBelongsTo = !empty($config['relations']['belongsTo']);
        $hasUploads = (bool) array_filter(
            (array) ($config['fields'] ?? []),
            static fn (array $field): bool => in_array(strtolower((string) ($field['inputType'] ?? '')), ['file', 'image'], true)
        );
        $uploadRoute = $hasUploads
            ? "    \$routes->get('upload/(:segment)/(:segment)', '{$controller}::upload/\$1/\$2');\n"
            : '';
        $viewRouteDoc = $isView ? "\n * SQL VIEW: read-only routes; no write route is generated." : '';
        $relationOptionsRoute = (!$isView && $hasBelongsTo)
            ? "    \$routes->get('relation-options/(:segment)', '{$controller}::relationOptions/\$1');\n"
            : '';

        $softRoutes = '';
        $apiRoute = static function (
            string $method,
            string $pattern,
            string $handler,
            string $capability
        ) use ($shieldTokens, $apiPermissions): string {
            $options = '';
            $permission = strtolower(trim((string) ($apiPermissions[$capability] ?? '')));
            if ($shieldTokens && $permission !== '') {
                $options = ", ['filter' => 'permission:" . addslashes($permission) . "']";
            }

            return "    \$routes->{$method}('" . $pattern . "', '" . $handler . "'" . $options . ");\n";
        };

        $softApiRoutes = '';
        if ($apiTrash) {
            $softApiRoutes .= $apiRoute('get', 'trash', "{$api}::trash", 'trash');
        }
        if ($apiRestore) {
            $softApiRoutes .= $apiRoute('post', '(:segment)/restore', "{$api}::restore/\$1", 'restore');
        }
        if ($apiForceDelete) {
            $softApiRoutes .= $apiRoute('delete', '(:segment)/force', "{$api}::forceDelete/\$1", 'forceDelete');
        }

        $apiListRoute = $apiList
            ? $apiRoute('get', '/', "{$api}::index", 'list')
            : '';
        $apiRecordRoutes = $apiRead
            ? $apiRoute('get', '(:segment)', "{$api}::show/\$1", 'read')
            : '';
        $apiCreateRoute = $apiCreate
            ? $apiRoute('post', '/', "{$api}::create", 'create')
            : '';
        $apiWriteRoutes = '';
        if ($apiUpdate) {
            $apiWriteRoutes .= $apiRoute('put', '(:segment)', "{$api}::update/\$1", 'update');
            $apiWriteRoutes .= $apiRoute('patch', '(:segment)', "{$api}::patch/\$1", 'update');
        }
        if ($apiDelete) {
            $apiWriteRoutes .= $apiRoute('delete', '(:segment)', "{$api}::delete/\$1", 'delete');
        }
        if ($apiUpdate && $hasUploads) {
            $apiWriteRoutes .= $apiRoute('post', '(:segment)/upload', "{$api}::upload/\$1", 'upload');
        }

        $apiRoutesBody = $apiListRoute . $softApiRoutes . $apiRecordRoutes . $apiCreateRoute . $apiWriteRoutes;
        $apiGroupOptions = $shieldTokens
            ? "['namespace' => 'App\\Controllers\\Api\\V1', 'filter' => 'tokens']"
            : "['namespace' => 'App\\Controllers\\Api\\V1']";
        $apiRoutes = ($apiEnabled && $apiRoutesBody !== '') ? <<<PHP

\$routes->group('api/v1/{$table}', {$apiGroupOptions}, static function (RouteCollection \$routes): void {
{$apiRoutesBody}});
PHP : '';

        $webRoute = static function (
            string $method,
            string $pattern,
            string $handler,
            string $capability
        ) use ($shieldSession, $crudPermissions): string {
            $options = '';
            $permission = strtolower(trim((string) ($crudPermissions[$capability] ?? '')));
            if ($shieldSession && $permission !== '') {
                $options = ", ['filter' => 'permission:" . addslashes($permission) . "']";
            }

            return "    \$routes->{$method}('" . $pattern . "', '" . $handler . "'" . $options . ");\n";
        };

        $webListRoutes = $webRoute('get', '/', "{$controller}::index", 'list')
            . $webRoute('get', 'export-csv', "{$controller}::exportCsv", 'list')
            . $webRoute('get', 'export-word', "{$controller}::exportWord", 'list');
        $webRecordRoute = $recordDetail ? $webRoute('get', 'view/(:segment)', "{$controller}::view/\$1", 'read') : '';
        $webCreateRoutes = $createAllowed
            ? $webRoute('get', 'create', "{$controller}::create", 'create')
                . $webRoute('post', 'store', "{$controller}::store", 'create')
            : '';
        $webWriteRoutes = $writable
            ? $webRoute('get', 'edit/(:segment)', "{$controller}::edit/\$1", 'update')
                . $webRoute('post', 'update/(:segment)', "{$controller}::update/\$1", 'update')
                . $webRoute('post', 'delete/(:segment)', "{$controller}::delete/\$1", 'delete')
            : '';
        if ($writable && !empty($config['features']['softDeletes'])) {
            $softRoutes .= $webRoute('get', 'trash', "{$controller}::trash", 'trash');
            $softRoutes .= $webRoute('post', 'restore/(:segment)', "{$controller}::restore/\$1", 'restore');
            $softRoutes .= $webRoute('post', 'force-delete/(:segment)', "{$controller}::forceDelete/\$1", 'forceDelete');
        }
        $webGroupOptions = $shieldSession ? ", ['filter' => 'session']" : '';

        $content = <<<PHP
<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD {$table}.
 * myCrudCI4 intentionally generates one file per table: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.{$viewRouteDoc}
 */

/** @var RouteCollection \$routes */
\$routes->group('{$table}'{$webGroupOptions}, static function (RouteCollection \$routes): void {
{$webListRoutes}{$relationOptionsRoute}{$uploadRoute}{$softRoutes}{$webRecordRoute}{$webCreateRoutes}{$webWriteRoutes}});{$apiRoutes}
PHP;

        return $this->writeGenerated("Generated/Routes/{$table}.php", $content, $force);
    }
}
