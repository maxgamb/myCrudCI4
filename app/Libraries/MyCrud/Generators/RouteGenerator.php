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
        $createAllowed = !empty($config['features']['createAllowed']);
        $writable = !empty($config['features']['writable']);
        $recordDetail = !empty($config['features']['recordDetail']);
        $isView = !empty($config['isView']);
        $viewRouteDoc = $isView ? "\n * SQL VIEW: route di sola lettura; nessuna route di scrittura viene generata." : '';
        $relationOptionsRoute = $isView ? '' : "    \$routes->get('relation-options/(:segment)', '{$controller}::relationOptions/\$1');\n";

        $softRoutes = $writable && !empty($config['features']['softDeletes'])
            ? "    \$routes->get('trash', '{$controller}::trash');\n    \$routes->post('restore/(:segment)', '{$controller}::restore/\$1');\n    \$routes->post('force-delete/(:segment)', '{$controller}::forceDelete/\$1');\n"
            : '';
        $softApiRoutes = $writable && !empty($config['features']['softDeletes'])
            ? "    \$routes->get('trash', '{$api}::trash');\n    \$routes->post('(:segment)/restore', '{$api}::restore/\$1');\n    \$routes->delete('(:segment)/force', '{$api}::forceDelete/\$1');\n"
            : '';

        $apiRecordRoutes = $recordDetail
            ? "    \$routes->get('(:segment)', '{$api}::show/\$1');\n"
            : '';
        $apiCreateRoute = $writable
            ? "    \$routes->post('/', '{$api}::create');\n"
            : '';
        $apiWriteRoutes = $writable
            ? "    \$routes->put('(:segment)', '{$api}::update/\$1');\n    \$routes->patch('(:segment)', '{$api}::patch/\$1');\n    \$routes->delete('(:segment)', '{$api}::delete/\$1');\n"
            : '';
        $apiRoutes = $apiEnabled ? <<<PHP

\$routes->group('api/v1/{$table}', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection \$routes): void {
    \$routes->get('/', '{$api}::index');
{$softApiRoutes}{$apiRecordRoutes}{$apiCreateRoute}{$apiWriteRoutes}});
PHP : '';

        $webRecordRoute = $recordDetail ? "    \$routes->get('view/(:segment)', '{$controller}::view/\$1');\n" : '';
        $webCreateRoutes = $createAllowed ? "    \$routes->get('create', '{$controller}::create');\n    \$routes->post('store', '{$controller}::store');\n" : '';
        $webWriteRoutes = $writable ? "    \$routes->get('edit/(:segment)', '{$controller}::edit/\$1');\n    \$routes->post('update/(:segment)', '{$controller}::update/\$1');\n    \$routes->post('delete/(:segment)', '{$controller}::delete/\$1');\n" : '';

        $content = <<<PHP
<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD {$table}.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.{$viewRouteDoc}
 */

/** @var RouteCollection \$routes */
\$routes->group('{$table}', static function (RouteCollection \$routes): void {
    \$routes->get('/', '{$controller}::index');
    \$routes->get('export-csv', '{$controller}::exportCsv');
    \$routes->get('export-word', '{$controller}::exportWord');
{$relationOptionsRoute}{$softRoutes}{$webRecordRoute}{$webCreateRoutes}{$webWriteRoutes}});{$apiRoutes}
PHP;

        return $this->writeGenerated("Generated/Routes/{$table}.php", $content, $force);
    }
}
