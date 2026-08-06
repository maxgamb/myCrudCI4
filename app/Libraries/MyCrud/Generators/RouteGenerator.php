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
        $architecture = (string) ($config['architecture'] ?? 'standard');
        $datatableRoute = $architecture === 'basic' ? '' : "    \$routes->post('datatable', '{$controller}::datatable');\n";
        $softRoutes = !empty($config['features']['softDeletes'])
            ? "    \$routes->get('trash', '{$controller}::trash');\n    \$routes->post('restore/(:segment)', '{$controller}::restore/\$1');\n    \$routes->post('force-delete/(:segment)', '{$controller}::forceDelete/\$1');\n"
            : '';
        $softApiRoutes = !empty($config['features']['softDeletes'])
            ? "    \$routes->get('trash', '{$api}::trash');\n    \$routes->post('(:segment)/restore', '{$api}::restore/\$1');\n    \$routes->delete('(:segment)/force', '{$api}::forceDelete/\$1');\n"
            : '';
        $apiRoutes = !empty($config['features']['api'])
            ? "\n\$routes->group('api/v1/{$table}', ['namespace' => 'App\\Controllers\\Api\\V1'], static function (RouteCollection \$routes): void {\n    \$routes->get('/', '{$api}::index');\n{$softApiRoutes}    \$routes->get('(:segment)', '{$api}::show/\$1');\n    \$routes->post('/', '{$api}::create');\n    \$routes->put('(:segment)', '{$api}::update/\$1');\n    \$routes->patch('(:segment)', '{$api}::patch/\$1');\n    \$routes->delete('(:segment)', '{$api}::delete/\$1');\n});\n"
            : '';

        $content = <<<PHP
<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection \$routes */
\$routes->group('{$table}', static function (RouteCollection \$routes): void {
    \$routes->get('/', '{$controller}::index');
{$datatableRoute}    \$routes->get('view/(:segment)', '{$controller}::view/\$1');
    \$routes->get('create', '{$controller}::create');
    \$routes->post('store', '{$controller}::store');
    \$routes->get('edit/(:segment)', '{$controller}::edit/\$1');
    \$routes->post('update/(:segment)', '{$controller}::update/\$1');
    \$routes->post('delete/(:segment)', '{$controller}::delete/\$1');
{$softRoutes}});
{$apiRoutes}
PHP;

        return $this->writeGenerated("Generated/Routes/{$table}.php", $content, $force);
    }
}
