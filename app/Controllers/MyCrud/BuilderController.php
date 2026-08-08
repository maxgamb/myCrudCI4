<?php

namespace App\Controllers\MyCrud;

use App\Controllers\BaseController;
use App\Libraries\MyCrud\Config\CrudConfigRepository;
use App\Libraries\MyCrud\Core\ConfigBuilder;
use App\Libraries\MyCrud\Core\CrudGeneratorService;
use App\Libraries\MyCrud\Schema\DbSchema;
use App\Libraries\MyCrud\Schema\TableFilter;
use CodeIgniter\Exceptions\PageNotFoundException;
use Throwable;

class BuilderController extends BaseController
{
    public function index()
    {
        $tables = TableFilter::validTables(db_connect());

        return view('mycrud/table_list', [
            'title'  => 'myCrudGpt',
            'tables' => $tables,
        ]);
    }

    public function configure(string $table)
    {
        try {
            $builder = new ConfigBuilder();
            $config  = $builder->buildFromTable($table);

            $saved = (new CrudConfigRepository())->load($table);
            if (is_array($saved)) {
                $config = $builder->mergeSavedConfiguration($config, $saved);
            }

            return view('mycrud/builder', [
                'title'  => 'Configura ' . $table,
                'config' => $config,
                'table'  => $table,
                'fields'               => $config['fields'],
                'databaseParentTables' => (new DbSchema())->parentTables(),
            ]);
        } catch (PageNotFoundException $e) {
            throw $e;
        }
    }

    public function save()
    {
        try {
            $config = (new ConfigBuilder())->buildFromRequest($this->request->getPost());
            (new CrudConfigRepository())->save($config['table'], $config);

            return redirect()
                ->to(site_url('mycrud/builder/configure/' . $config['table']))
                ->with('message', 'Configurazione salvata.');
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function generate()
    {
        try {
            $post   = $this->request->getPost();
            $config = (new ConfigBuilder())->buildFromRequest($post);
            $force  = !empty($post['force']);

            (new CrudConfigRepository())->save($config['table'], $config);
            $result = (new CrudGeneratorService())->generate($config, $force);

            return view('mycrud/result', [
                'title'  => 'Generazione personalizzata',
                'table'  => $config['table'],
                'result' => $result,
            ]);
        } catch (Throwable $e) {
            log_message('error', '[myCrudGpt] {message}', ['message' => $e->getMessage()]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
