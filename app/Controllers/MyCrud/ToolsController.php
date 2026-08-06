<?php

declare(strict_types=1);

namespace App\Controllers\MyCrud;

use App\Controllers\BaseController;
use App\Libraries\MyCrud\Core\Naming;
use App\Libraries\MyCrud\Schema\DbSchema;
use App\Libraries\MyCrud\Schema\TableFilter;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Database;
use Throwable;

final class ToolsController extends BaseController
{
    public function routes(): string|RedirectResponse
    {
        try {
            $db = Database::connect();

            $output = <<<'PHP'
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

PHP;

            foreach (TableFilter::validTables($db, config('MyCrud')) as $table) {
                $controller = Naming::singularStudly($table) . 'Controller';

                $output .= "\$routes->group('{$table}', static function (RouteCollection \$routes): void {\n";
                $output .= "    \$routes->get('/', '{$controller}::index');\n";
                $output .= "    \$routes->post('datatable', '{$controller}::datatable');\n";
                $output .= "    \$routes->get('view/(:segment)', '{$controller}::view/\$1');\n";
                $output .= "    \$routes->get('create', '{$controller}::create');\n";
                $output .= "    \$routes->post('store', '{$controller}::store');\n";
                $output .= "    \$routes->get('edit/(:segment)', '{$controller}::edit/\$1');\n";
                $output .= "    \$routes->post('update/(:segment)', '{$controller}::update/\$1');\n";
                $output .= "    \$routes->post('delete/(:segment)', '{$controller}::delete/\$1');\n";
                $output .= "});\n\n";
            }

            return view('mycrud/code_output', [
                'title'   => 'Routes',
                'heading' => 'Routes CRUD',
                'code'    => $output,
            ]);
        } catch (Throwable $e) {
            log_message(
                'error',
                '[myCrudGpt tools routes] {message} in {file}:{line}',
                [
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine(),
                ]
            );

            return redirect()
                ->to(site_url('mycrud'))
                ->with('error', $e->getMessage());
        }
    }

    public function fields(): string|RedirectResponse
    {
        try {
            $db     = Database::connect();
            $config = config('MyCrud');

            $path = APPPATH
                . 'Language/'
                . $config->defaultLocale
                . '/Fields.php';

            $fields = [];

            if (is_file($path)) {
                $loaded = require $path;

                if (is_array($loaded)) {
                    $fields = $loaded;
                }
            }

            foreach (TableFilter::validTables($db, $config) as $table) {
                foreach ($db->getFieldNames($table) as $column) {
                    $fields[$column] ??= Naming::human($column);
                }
            }

            ksort($fields);

            $output = "<?php\n\nreturn [\n";

            foreach ($fields as $column => $label) {
                $output .= sprintf(
                    "    %s => %s,\n",
                    var_export((string) $column, true),
                    var_export((string) $label, true)
                );
            }

            $output .= "];\n";

            return view('mycrud/code_output', [
                'title'   => 'Fields.php',
                'heading' => 'Traduzioni Fields.php',
                'code'    => $output,
            ]);
        } catch (Throwable $e) {
            log_message(
                'error',
                '[myCrudGpt tools fields] {message} in {file}:{line}',
                [
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine(),
                ]
            );

            return redirect()
                ->to(site_url('mycrud'))
                ->with('error', $e->getMessage());
        }
    }

    public function schema(?string $table = null): string|RedirectResponse
    {
        try {
            $info = (new DbSchema())->getSchemaInfo($table);

            return view('mycrud/schema', [
                'title' => $table !== null
                    ? 'Schema ' . $table
                    : 'Schema database',

                'table' => $table,
                'info'  => $info,
            ]);
        } catch (Throwable $e) {
            log_message(
                'error',
                '[myCrudGpt tools schema] {message} in {file}:{line}',
                [
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine(),
                ]
            );

            return redirect()
                ->to(site_url('mycrud/tools/schema'))
                ->with('error', $e->getMessage());
        }
    }
}

