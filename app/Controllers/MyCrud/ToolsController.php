<?php
namespace App\Controllers\MyCrud;

use App\Controllers\BaseController;
use App\Libraries\MyCrud\Core\MenuBuilderService;
use App\Libraries\MyCrud\Core\Naming;
use App\Libraries\MyCrud\Schema\DbSchema;
use App\Libraries\MyCrud\Generators\MenuGenerator;
use App\Libraries\MyCrud\Schema\TableFilter;
use Config\Database;

class ToolsController extends BaseController
{
    public function routes(): string
    {
        $db = Database::connect();
        $output = "<?php\n\nuse CodeIgniter\\Router\\RouteCollection;\n\n";

        foreach (TableFilter::validTables($db) as $table) {
            $controller = Naming::tableClass($table) . 'Controller';
            $output .= "\$routes->group('{$table}', static function (RouteCollection \$routes): void {\n";
            $output .= "    \$routes->get('/', '{$controller}::index');\n";
            $output .= "    \$routes->get('export-csv', '{$controller}::exportCsv');\n";
            $output .= "    \$routes->get('export-word', '{$controller}::exportWord');\n";
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


    /**
     * Mostra il Menu Builder guidato.
     *
     * Lo schema DB fornisce soltanto voci disponibili e relazioni informative:
     * l'aggregazione finale viene decisa esplicitamente dallo sviluppatore.
     */
    public function menu(): string
    {
        $data = (new MenuBuilderService())->builderData();

        return view('mycrud/menu_builder', [
            'title' => 'Generatore Menu',
            'items' => $data['items'],
            'related' => $data['related'],
            'relationCount' => $data['relationCount'],
        ]);
    }

    /** Genera configurazione e renderer Bootstrap esclusivamente nello staging. */
    public function generateMenu(): string
    {
        $builder = new MenuBuilderService();
        $menu = $builder->fromRequest($this->request->getPost());
        $force = (bool) $this->request->getPost('force');
        $files = (new MenuGenerator())->generate($menu, $force);

        return view('mycrud/menu_result', [
            'title' => 'Menu generato',
            'type' => $menu['type'],
            'files' => $files,
        ]);
    }

    public function schema(?string $table = null)
    {
        return view('mycrud/schema', [
            'title' => $table ? 'Schema ' . $table : 'Schema database',
            'info' => (new DbSchema())->getSchemaInfo($table),
        ]);
    }
}
