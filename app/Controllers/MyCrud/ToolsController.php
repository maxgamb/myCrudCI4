<?php
namespace App\Controllers\MyCrud;

use App\Controllers\BaseController;
use App\Libraries\MyCrud\Core\Naming;
use App\Libraries\MyCrud\Schema\DbSchema;
use App\Libraries\MyCrud\Schema\TableFilter;
use Config\Database;

class ToolsController extends BaseController
{
    public function routes(): string
    {
        $db = Database::connect();
        $output = "<?php\n\nuse CodeIgniter\\Router\\RouteCollection;\n\n";

        foreach (TableFilter::validTables($db) as $table) {
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

        return view('mycrud/code_output', ['title'=>'Routes','heading'=>'Routes CRUD','code'=>$output]);
    }

    public function fields(): string
    {
        $db = Database::connect();
        $config = config('MyCrud');
        $path = APPPATH . 'Language/' . $config->defaultLocale . '/Fields.php';
        $fields = is_file($path) && is_array($loaded = require $path) ? $loaded : [];

        foreach (TableFilter::validTables($db, $config) as $table) {
            foreach ($db->getFieldNames($table) as $column) {
                $fields[$column] ??= Naming::human($column);
            }
        }

        ksort($fields);
        $output = "<?php\n\nreturn [\n";
        foreach ($fields as $column => $label) {
            $output .= '    ' . var_export($column, true) . ' => ' . var_export($label, true) . ",\n";
        }
        $output .= "];\n";

        return view('mycrud/code_output', ['title'=>'Fields.php','heading'=>'Traduzioni Fields.php','code'=>$output]);
    }

    public function schema(?string $table = null)
    {
        return view('mycrud/schema', [
            'title' => $table ? 'Schema ' . $table : 'Schema database',
            'info' => (new DbSchema())->getSchemaInfo($table),
        ]);
    }
}
