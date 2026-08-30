<?php
namespace App\Controllers\MyCrud;

use App\Controllers\BaseController;
use App\Libraries\MyCrud\Core\MenuBuilderService;
use App\Libraries\MyCrud\Analysis\DomainAnalyzer;
use App\Libraries\MyCrud\Config\MenuConfigRepository;
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
     * Displays the guided Menu Builder.
     *
     * Lo DB schema fornisce soltanto voci disponibili e relations informative:
     * l'aggregazione finale viene decisa esplicitamente dallo sviluppatore.
     */
    public function menu(): string
    {
        $data = (new MenuBuilderService())->builderData();
        $repository = new MenuConfigRepository();
        $savedMenu = $repository->load();

        return view('mycrud/menu_builder', [
            'title' => 'Menu Generator',
            'items' => $data['items'],
            'related' => $data['related'],
            'relationCount' => $data['relationCount'],
            'savedMenu' => $savedMenu,
            'menuConfigPath' => $repository->path(),
        ]);
    }

    /** Saves Menu Builder configuration without generating runtime files. */
    public function saveMenu()
    {
        $menu = (new MenuBuilderService())->fromRequest($this->request->getPost());
        $path = (new MenuConfigRepository())->save($menu);

        return redirect()
            ->to(site_url('mycrud/tools/menu'))
            ->with('message', 'Menu configuration saved to ' . $path);
    }

    /** Generates configuration and Bootstrap renderer exclusively in staging. */
    public function generateMenu(): string
    {
        $builder = new MenuBuilderService();
        $menu = $builder->fromRequest($this->request->getPost());
        $force = (bool) $this->request->getPost('force');
        $files = (new MenuGenerator())->generate($menu, $force);

        return view('mycrud/menu_result', [
            'title' => 'Menu generated',
            'type' => $menu['type'],
            'files' => $files,
        ]);
    }

    /**
     * Shows a deterministic resource/domain map inferred from DB structure.
     * No CRUD configuration or source file is modified.
     */
    public function domain(): string
    {
        return view('mycrud/domain_analyzer', [
            'title' => 'Domain Analyzer',
            'analysis' => (new DomainAnalyzer())->analyze(),
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
