<?php

namespace App\Libraries\MyCrud\Generators;

class RouteGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $table      = $config['table'];
        $controller = $config['classes']['controller'];
        $api        = $config['classes']['api'];

        $softDeleteRoutes = '';
        if (!empty($config['features']['softDeletes'])) {
            $softDeleteRoutes = <<<PHP
    \$routes->get('trash', '{$controller}::trash');
    \$routes->post('restore/(:segment)', '{$controller}::restore/\$1');
    \$routes->post('force-delete/(:segment)', '{$controller}::forceDelete/\$1');
PHP;
        }

        $apiRoutes = '';
        if (!empty($config['features']['api'])) {
            $apiRoutes = <<<PHP

\$routes->group('api/{$table}', ['namespace' => 'App\\Controllers\\Api'], static function (RouteCollection \$routes): void {
    \$routes->get('/', '{$api}::index');
    \$routes->get('(:segment)', '{$api}::show/\$1');
    \$routes->post('/', '{$api}::create');
    \$routes->put('(:segment)', '{$api}::update/\$1');
    \$routes->patch('(:segment)', '{$api}::update/\$1');
    \$routes->delete('(:segment)', '{$api}::delete/\$1');
});
PHP;
        }

        $content = <<<PHP
<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection \$routes */
\$routes->group('{$table}', static function (RouteCollection \$routes): void {
    \$routes->get('/', '{$controller}::index');
    \$routes->post('datatable', '{$controller}::datatable');
    \$routes->get('view/(:segment)', '{$controller}::view/\$1');
    \$routes->get('create', '{$controller}::create');
    \$routes->post('store', '{$controller}::store');
    \$routes->get('edit/(:segment)', '{$controller}::edit/\$1');
    \$routes->post('update/(:segment)', '{$controller}::update/\$1');
    \$routes->post('delete/(:segment)', '{$controller}::delete/\$1');
{$softDeleteRoutes}
});
{$apiRoutes}

PHP;

        return $this->writeGenerated("Routes/{$table}.php", $content, $force);
    }
}
